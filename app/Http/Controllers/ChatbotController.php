<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    private function getSystemPrompt(): string
    {
        return <<<PROMPT
You are "Teshome", the friendly AI assistant for "የኛ ገበያ" (Yegna Gebya) — an Ethiopian e-commerce platform.

=== LANGUAGE RULE ===
Detect the language the user writes in and ALWAYS respond in that SAME language.
Amharic → Amharic. English → English. Arabic → Arabic. Any language → same language.

=== RESPONSE RULE ===
- Always give a COMPLETE, DIRECT, HELPFUL answer.
- Never stop mid-sentence. Never just say "Hello" without answering.
- Keep responses under 5 sentences unless a list is needed.
- For security/risk issues (hacking, fraud, data breach, payment fraud, account compromise) → say: "This is a security concern. Please email us directly at tesheyimer86@gmail.com with details."

=== FULL PLATFORM KNOWLEDGE ===

**About the Platform:**
- Name: የኛ ገበያ (Yegna Gebya)
- Type: Ethiopian e-commerce website
- URL: http://127.0.0.1:8000 (local) / hosted on Railway
- Admin panel: /admin (Filament-based, for Teshome only)
- Built with: Laravel 10, PHP 8.2, MySQL, Bootstrap 5, Filament 3

**Products:**
- Categories: Electronics, Clothing, Sports, Books, Home & Garden
- Brands: Apple, Samsung, Nike, Adidas, Sony and more
- Each product has: name, description, price (in Birr), images, stock status, featured/sale badges
- Products page: /products — filter by category, brand, sort by price/name

**User Registration & Login:**
- Register at /register — fill name, email, password
- Login at /login — email + password
- Social login: Google, GitHub, Facebook (OAuth)
- Forgot password: /password/reset — enter email, get reset link
- Change password: Profile Settings → "የይለፍ ቃል ቀይር" section
- Email verification required after registration

**Shopping & Cart:**
- Add to cart from products page or product detail page
- Cart at /cart — update quantity, remove items, clear cart
- Cart works for guests (session) and logged-in users
- Shipping cost: Birr 150 flat rate

**Checkout:**
- Go to /checkout after cart
- Fill shipping address: name, phone, street, city, region, country, zip
- Choose payment method

**Payment Methods:**
- Chapa (Ethiopian): Telebirr, CBEBirr, Visa/Mastercard, Cards
- Bank Transfer: CBE, Awash Bank, Dashen Bank
- Mobile Wallet: Telebirr, HelloCash
- All payments are encrypted and secure

**Delivery:**
- Delivery time: 2-5 business days
- Delivery cost: Birr 150
- Covers all regions of Ethiopia
- Track order status in "ትዕዛዞቼ" (My Orders) page

**Order Management:**
- View orders at /orders
- Order statuses: አዲስ (New) → በሂደት (Processing) → ተላከ (Shipped) → ደረሰ (Delivered)
- Cancel order: only when status is New or Processing
- Reorder: available for Delivered orders
- Download invoice: available for paid orders

**Returns & Refunds:**
- Return within 7 days of receiving the product
- Product must be unused and in original condition
- Contact: tesheyimer86@gmail.com for return requests

**User Profile:**
- Edit at /profile
- Change name, email, profile photo (avatar upload)
- Change password
- Delete account (permanent)

**Dashboard:**
- At /dashboard — shows total orders, total spent, recent orders, quick actions

**Admin Panel (/admin):**
- Only accessible by admin (Teshome)
- Manage: Products, Categories, Brands, Orders, Users
- View stats: Total Products, Orders, Revenue, Users
- Order management: update status, view details

**Contact & Support:**
- Email: tesheyimer86@gmail.com
- Phone: 0962868748
- Support hours: Monday-Saturday 8am-6pm

**Security Policy:**
- For any security risks (hacking attempts, fraud, payment issues, data concerns, account compromise, suspicious activity) → always direct to email: tesheyimer86@gmail.com
- Do NOT try to solve security issues in chat

=== END OF KNOWLEDGE ===
PROMPT;
    }

    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $userMessage = $request->message;
        $apiKey = env('GEMINI_API_KEY');
        $prompt = $this->getSystemPrompt() . "\n\nCustomer: " . $userMessage . "\nTeshome:";

        $models = ['gemini-2.0-flash', 'gemini-2.0-flash-lite', 'gemini-2.5-flash'];

        foreach ($models as $model) {
            try {
                $response = Http::timeout(12)->withHeaders([
                    'Content-Type' => 'application/json',
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                    'contents' => [[
                        'parts' => [['text' => $prompt]]
                    ]],
                    'generationConfig' => [
                        'temperature'     => 0.5,
                        'maxOutputTokens' => 500,
                        'stopSequences'   => ['Customer:'],
                    ]
                ]);

                if ($response->successful()) {
                    $data  = $response->json();
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if ($reply && strlen(trim($reply)) > 5) {
                        return response()->json(['reply' => trim($reply)]);
                    }
                }

                if ($response->status() !== 429) break;

            } catch (\Exception $e) {
                continue;
            }
        }

        // Smart fallback
        return response()->json(['reply' => $this->smartFallback($userMessage)]);
    }

    private function smartFallback(string $msg): string
    {
        $m = mb_strtolower($msg);

        // Security/Risk issues → email only
        if ($this->has($m, ['hack', 'fraud', 'breach', 'stolen', 'compromise', 'attack', 'vulnerability', 'exploit', 'risk', 'security issue', 'suspicious', 'ጠለፋ', 'ስጋት', 'አደጋ'])) {
            return "⚠️ This is a security concern. Please email us directly at tesheyimer86@gmail.com with full details. Do not share sensitive information in chat.";
        }
        if ($this->has($m, ['ሰላም', 'hello', 'hi', 'hey', 'selam', 'ሃይ', 'good morning', 'good evening'])) {
            return "👋 ሰላም! እኔ Teshome ነኝ — የኛ ገበያ ድጋፍ። ምን ልረዳዎ እችላለሁ?";
        }
        if ($this->has($m, ['password', 'የይለፍ ቃል', 'ፓስወርድ', 'forgot', 'reset', 'ረሱ', 'change password', 'መቀየር'])) {
            return "🔐 የይለፍ ቃል ለመቀየር:\n1. ወደ መለያዎ ይግቡ\n2. ከላይ ስምዎን ጠቅ ያድርጉ → 'የእኔ መለያ'\n3. 'የይለፍ ቃል ቀይር' ክፍሉን ይሙሉ\n\nForgot password? Go to /password/reset and enter your email.";
        }
        if ($this->has($m, ['register', 'sign up', 'create account', 'ይመዝገቡ', 'አዲስ መለያ'])) {
            return "📝 To register: go to /register, fill your name, email and password. You can also sign up with Google, GitHub or Facebook.";
        }
        if ($this->has($m, ['login', 'sign in', 'ይግቡ', 'መግባት', 'log in'])) {
            return "🔑 To login: go to /login and enter your email and password. You can also login with Google, GitHub or Facebook.";
        }
        if ($this->has($m, ['ዋጋ', 'price', 'ምን ያህል', 'ስንት', 'how much', 'cost'])) {
            return "💰 Product prices are shown on the Products page (/products). Each product shows its price in Birr. Shipping costs an additional Birr 150.";
        }
        if ($this->has($m, ['payment', 'ክፍያ', 'telebirr', 'cbe', 'bank', 'ባንክ', 'pay', 'how to pay'])) {
            return "💳 Payment methods:\n• Telebirr & CBEBirr\n• Visa / Mastercard\n• Bank Transfer (CBE, Awash, Dashen)\n• HelloCash\n\nAll payments are processed securely via Chapa.";
        }
        if ($this->has($m, ['delivery', 'shipping', 'ማድረስ', 'how long', 'how many days', 'when', 'ምን ያህል ቀን'])) {
            return "🚚 Delivery takes 2-5 business days across all regions of Ethiopia. Shipping cost is Birr 150 flat rate.";
        }
        if ($this->has($m, ['order', 'ትዕዛዝ', 'track', 'status', 'ሁኔታ', 'where is my'])) {
            return "📦 To track your order: login → click your name → 'ትዕዛዞቼ' (My Orders). You can see status: New → Processing → Shipped → Delivered.";
        }
        if ($this->has($m, ['cancel', 'ሰርዝ', 'cancellation'])) {
            return "❌ You can cancel an order only when its status is 'New' or 'Processing'. Go to My Orders → find your order → click 'ሰርዝ'.";
        }
        if ($this->has($m, ['return', 'refund', 'መመለስ', 'ተመላሽ', 'money back'])) {
            return "↩️ Returns are accepted within 7 days of receiving the product. The item must be unused. Email us at tesheyimer86@gmail.com to start a return.";
        }
        if ($this->has($m, ['product', 'ምርት', 'electronics', 'phone', 'laptop', 'clothes', 'sport', 'ልብስ'])) {
            return "🛍️ We sell Electronics, Clothing, Sports gear, Books, and Home items. Browse all products at /products — filter by category or brand.";
        }
        if ($this->has($m, ['profile', 'account', 'መለያ', 'photo', 'avatar', 'ፎቶ', 'name', 'email change'])) {
            return "👤 To edit your profile: login → click your name → 'የእኔ መለያ'. You can update your name, email, profile photo, and password.";
        }
        if ($this->has($m, ['admin', 'dashboard', 'ዳሽቦርድ'])) {
            return "⚙️ The admin panel is at /admin — accessible only by the shop owner. It manages products, orders, users, categories and brands.";
        }
        if ($this->has($m, ['contact', 'አድራሻ', 'ስልክ', 'phone', 'email', 'reach', 'support'])) {
            return "📞 Contact us:\n• Email: tesheyimer86@gmail.com\n• Phone: 0962868748\n• Hours: Mon-Sat, 8am–6pm";
        }
        if ($this->has($m, ['thank', 'አመሰግናለሁ', 'tnx', 'thanks', 'great', 'good'])) {
            return "😊 You're welcome! Feel free to ask anything else. Happy shopping at የኛ ገበያ! 🛍️";
        }

        return "🤔 I'm not sure about that right now. For general questions, browse our site or contact us:\n• 📧 tesheyimer86@gmail.com\n• 📞 0962868748";
    }

    private function has(string $text, array $keywords): bool
    {
        foreach ($keywords as $kw) {
            if (str_contains($text, mb_strtolower($kw))) return true;
        }
        return false;
    }
}
