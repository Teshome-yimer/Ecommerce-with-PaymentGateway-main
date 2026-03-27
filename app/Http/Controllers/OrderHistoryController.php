<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    /**
     * Display order history for authenticated user
     */
    public function index(Request $request)
    {
        $query = Order::where('id_user', Auth::id())
            ->with(['items.product.category', 'items.product.brand', 'address'])
            ->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status if provided
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order ID or product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('items.product', function($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(10)->withQueryString();

        // Get filter options
        $statusOptions = [
            'new' => 'New',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'canceled' => 'Canceled'
        ];

        $paymentStatusOptions = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refunded' => 'Refunded'
        ];

        return view('orders.history', compact('orders', 'statusOptions', 'paymentStatusOptions'));
    }

    /**
     * Show specific order details
     */
    public function show(Order $order)
    {
        // Check if user owns this order
        if ($order->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Load relationships
        $order->load(['items.product.category', 'items.product.brand', 'address', 'user']);

        return view('orders.detail', compact('order'));
    }

    /**
     * Cancel order (if allowed)
     */
    public function cancel(Order $order)
    {
        // Check if user owns this order
        if ($order->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Check if order can be canceled
        if (!in_array($order->status, ['new', 'processing'])) {
            return back()->with('error', 'This order cannot be canceled.');
        }

        // Update order status
        $order->update([
            'status' => 'canceled'
        ]);

        return back()->with('success', 'Order has been canceled successfully.');
    }

    /**
     * Reorder - add items to cart
     */
    public function reorder(Order $order)
    {
        // Check if user owns this order
        if ($order->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $cart = session()->get('cart', []);
        $addedItems = 0;

        foreach ($order->items as $item) {
            // Check if product still exists and is available
            if ($item->product && $item->product->in_stock) {
                $productId = $item->product->id;

                if (isset($cart[$productId])) {
                    // Update quantity if already in cart
                    $cart[$productId]['quantity'] += $item->quantity;
                } else {
                    // Add new item to cart
                    $cart[$productId] = [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'image' => $item->product->images[0] ?? null,
                    ];
                }
                $addedItems++;
            }
        }

        session()->put('cart', $cart);

        if ($addedItems > 0) {
            return redirect()->route('cart')->with('success', "{$addedItems} items have been added to your cart.");
        } else {
            return back()->with('error', 'No items could be added to cart. Products may be out of stock.');
        }
    }
}
