<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $userMessage = $request->message;
        $apiKey = env('GEMINI_API_KEY');

        $systemContext = "You are 'Teshome', a friendly customer support assistant for 'የኛ ገበያ' (Yegna Gebya), an Ethiopian e-commerce platform.
Always respond in Amharic (Ethiopian language) unless the user writes in English.
Be friendly, concise and helpful. Keep responses under 100 words.
The shop sells electronics, clothing, sports items and more.
Payment: Chapa (Telebirr, CBEBirr, Cards) and Bank Transfer.
Delivery: across Ethiopia. Return policy: 7 days.
Shipping cost: Birr 150. Orders tracked via order history page.";

        // Try Gemini API
        $models = ['gemini-2.0-flash-lite', 'gemini-2.0-flash', 'gemini-2.5-flash'];

        foreach ($models as $model) {
            try {
                $response = Http::timeout(10)->withHeaders([
                    'Content-Type' => 'application/json',
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                    'contents' => [[
                        'parts' => [['text' => $systemContext . "\n\nCustomer: " . $userMessage . "\nTeshome:"]]
                    ]],
                    'generationConfig' => ['temperature' => 0.7, 'maxOutputTokens' => 200]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if ($reply) {
                        return response()->json(['reply' => trim($reply)]);
                    }
                }

                if ($response->status() !== 429) break;

            } catch (\Exception $e) {
                continue;
            }
        }

        // Smart fallback responses when API quota exceeded
        return response()->json(['reply' => $this->smartFallback($userMessage)]);
    }

    private function smartFallback(string $msg): string
    {
        $msg = mb_strtolower($msg);

        if ($this->contains($msg, ['ሰላም', 'hello', 'hi', 'selam', 'ሃይ'])) {
            return "👋 ሰላም! እኔ Teshome ነኝ። ምን ልረዳዎ እችላለሁ?";
        }
        if ($this->contains($msg, ['ዋጋ', 'price', 'ምን ያህል', 'ስንት'])) {
            return "💰 ዋጋዎቻችን በምርቶቹ ገጽ ላይ ይታያሉ። ምርቶቹን ለማየት 'ምርቶች' ይጫኑ። ለተለየ ምርት ዋጋ ስሙን ይጻፉልኝ።";
        }
        if ($this->contains($msg, ['ክፍያ', 'payment', 'telebirr', 'cbe', 'ባንክ', 'bank'])) {
            return "💳 ክፍያ ዘዴዎቻችን:\n• Telebirr\n• CBEBirr\n• ካርድ (Visa/Mastercard)\n• ባንክ ዝውውር\n\nሁሉም ክፍያዎች Chapa በኩል ደህንነቱ ተጠብቆ ይሰራሉ።";
        }
        if ($this->contains($msg, ['ማድረስ', 'delivery', 'shipping', 'መላክ', 'ምን ያህል ቀን'])) {
            return "🚚 ማድረሻ:\n• ዋጋ: Birr 150\n• ጊዜ: 2-5 የስራ ቀናት\n• ኢትዮጵያ ሁሉም ቦታ እናደርሳለን";
        }
        if ($this->contains($msg, ['ትዕዛዝ', 'order', 'ያዘዝኩ', 'status', 'ሁኔታ'])) {
            return "📦 ትዕዛዝዎን ለማየት:\n1. ወደ መለያዎ ይግቡ\n2. 'ትዕዛዞቼ' ይጫኑ\n3. ትዕዛዝዎን ይፈልጉ\n\nችግር ካለ ኢሜይል ይላኩልን: tesheyimer86@gmail.com";
        }
        if ($this->contains($msg, ['መመለስ', 'return', 'refund', 'ተመላሽ'])) {
            return "↩️ የመመለስ ፖሊሲ:\n• ምርቱ ከደረሰ በ7 ቀናት ውስጥ መመለስ ይቻላል\n• ምርቱ ሳይጠቀሙ መሆን አለበት\n• ለዝርዝር: tesheyimer86@gmail.com";
        }
        if ($this->contains($msg, ['ምርት', 'product', 'electronics', 'ልብስ', 'sport'])) {
            return "🛍️ ምርቶቻችን:\n• ኤሌክትሮኒክስ\n• ልብስ\n• ስፖርት\n• ቤት እቃዎች\n\nሁሉንም ለማየት 'ምርቶች' ይጫኑ!";
        }
        if ($this->contains($msg, ['register', 'ይመዝገቡ', 'account', 'መለያ', 'login', 'ይግቡ'])) {
            return "👤 መለያ ለመፍጠር:\n1. 'ይመዝገቡ' ይጫኑ\n2. ስምዎን፣ ኢሜይልዎን ያስገቡ\n3. Google ወይም Facebook ሊጠቀሙ ይችላሉ";
        }
        if ($this->contains($msg, ['አመሰግናለሁ', 'thanks', 'thank you', 'tnx'])) {
            return "😊 እናመሰግናለን! ሌላ ጥያቄ ካለዎ ሁልጊዜ ዝግጁ ነኝ። ደህና ይሁኑ! 🙏";
        }
        if ($this->contains($msg, ['contact', 'አድራሻ', 'ስልክ', 'phone', 'email', 'ኢሜይል'])) {
            return "📞 አድራሻ:\n• ኢሜይል: tesheyimer86@gmail.com\n• ስልክ: 0962868748\n• ሰዓት: ሰኞ-ቅዳሜ 8am-6pm";
        }

        return "🤔 ጥያቄዎን ተቀብያለሁ። አሁን ቀጥታ ለመመለስ ትንሽ ችግር አለ። እባክዎ:\n• ኢሜይል: tesheyimer86@gmail.com\n• ስልክ: 0962868748\n\nወይም ጥቂት ቆይተው እንደገና ይሞክሩ።";
    }

    private function contains(string $text, array $keywords): bool
    {
        foreach ($keywords as $kw) {
            if (str_contains($text, $kw)) return true;
        }
        return false;
    }
}
