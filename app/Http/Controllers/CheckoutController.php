<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http; // ለ Chapa API ጥሪ ያስፈልጋል
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Midtrans config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum('total_amount');
        $shippingCost = 150; // ለኢትዮጵያ ብር ከሆነ መጠኑን አስተካክለው (ለምሳሌ 150 ብር)
        $grandTotal = $total + $shippingCost;

        return view('checkout', compact('cartItems', 'total', 'shippingCost', 'grandTotal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'payment_method' => 'required'
        ]);

        $cartItems = $this->getCartItems();
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $total = $cartItems->sum('total_amount');
        $shippingCost = 150;
        $grandTotal = $total + $shippingCost;

        try {
            DB::beginTransaction();

            // 1. Order መፍጠር
            $order = Order::create([
                'id_user' => Auth::id(),
                'grand_total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'new',
                'currency' => ($request->payment_method == 'chapa') ? 'ETB' : 'IDR',
                'shipping_amount' => $shippingCost,
                'shipping_method' => 'standard',
            ]);

            // 2. Order Items መፍጠር
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'id_order' => $order->id,
                    'id_product' => $cartItem->id_product,
                    'quantity' => $cartItem->quantity,
                    'unit_amount' => $cartItem->unit_amount,
                    'total_amount' => $cartItem->total_amount,
                ]);
            }

            // 3. Address መፍጠር
            Address::create([
                'id_order' => $order->id,
                'id_user' => Auth::id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip_code' => $request->zip_code,
            ]);

            $tx_ref = 'TXN-' . $order->id . '-' . time();

            // --- CHAPA LOGIC ---
           // --- CHAPA LOGIC ---
if ($request->payment_method == 'chapa') {
    // መጠኑ ከ 1 ሚሊዮን በላይ ከሆነ ለሙከራ ያህል እንዲቀንስ (Test ለማድረግ ብቻ)
    $finalAmount = ($grandTotal > 1000000) ? 500 : $grandTotal;

    $response = Http::withToken(env('CHAPA_SECRET_KEY'))
        ->post('https://api.chapa.co/v1/transaction/initialize', [
            'amount' => $finalAmount, // የተስተካከለ መጠን
            'currency' => 'ETB',
            'email' => Auth::user()->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'tx_ref' => $tx_ref,
            'callback_url' => route('checkout.success', $order->id),
            'return_url' => route('checkout.success', $order->id),
            'customization' => [
                'title' => 'Order ' . $order->id, // አጭር Title (ከ16 ፊደል ያነሰ)
                'description' => 'Payment'
            ]
        ]);
    // ... ቀሪው ኮድ

                if ($response->successful()) {
                    $this->clearCart();
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'checkout_url' => $response->json()['data']['checkout_url']
                    ]);
                } else {
                    throw new \Exception('Chapa initialization failed: ' . $response->body());
                }
            }

            // --- MIDTRANS LOGIC ---
            else {
                $params = [
                    'transaction_details' => [
                        'order_id' => $tx_ref,
                        'gross_amount' => (int) $grandTotal,
                    ],
                    'customer_details' => [
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => Auth::user()->email,
                        'phone' => $request->phone,
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
                $this->clearCart();
                DB::commit();

                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'order_id' => $order->id
                ]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function success($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('id_user', Auth::id())
            ->with(['items.product', 'address'])
            ->firstOrFail();

        // Chapa ከሆነ ክፍያውን አፕዴት ማድረግ ትችላለህ (እዚህ ጋር Verify ማድረግ ይቻላል)
        $order->update(['payment_status' => 'paid', 'status' => 'processing']);

        return view('checkout-success', compact('order'));
    }

    private function getCartItems()
    {
        return Cart::where('id_user', Auth::id())
            ->with('product')
            ->get();
    }

    private function clearCart()
    {
        Cart::where('id_user', Auth::id())->delete();
    }
}