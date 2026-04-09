<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum('total_amount');

        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active || !$product->in_stock) {
            return response()->json(['error' => 'Product not available'], 400);
        }

        $userId = Auth::id();
        $sessionId = session()->getId();

        // Check if item already exists in cart
        $cartItem = Cart::where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('id_user', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->where('id_product', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->total_amount = $cartItem->quantity * $product->price;
            $cartItem->save();
        } else {
            // Create new cart item
            Cart::create([
                'id_user' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'id_product' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_amount' => $product->price,
                'total_amount' => $request->quantity * $product->price,
            ]);
        }

        $cartCount = $this->getCartCount();

        return response()->json([
            'success' => true,
            'message' => 'ምርቱ ወደ ጋሪ ተጨምሯል! 🛒',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = $this->findCartItem($id);

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->total_amount = $cartItem->quantity * $cartItem->unit_amount;
        $cartItem->save();

        $total = $this->getCartItems()->sum('total_amount');

        return response()->json([
            'success' => true,
            'item_total' => $cartItem->total_amount,
            'cart_total' => $total
        ]);
    }

    public function remove($id)
    {
        $cartItem = $this->findCartItem($id);

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        $cartItem->delete();

        $cartCount = $this->getCartCount();
        $total = $this->getCartItems()->sum('total_amount');

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => $total
        ]);
    }

    public function clear()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        Cart::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('id_user', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete();

        return response()->json(['success' => true]);
    }

    private function getCartItems()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        return Cart::where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('id_user', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->with('product')
            ->get();
    }

    private function getCartCount()
    {
        return $this->getCartItems()->sum('quantity');
    }

    private function findCartItem($id)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        return Cart::where('id', $id)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('id_user', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();
    }
}
