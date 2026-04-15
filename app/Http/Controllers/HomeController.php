<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect to login if not authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->where('in_stock', true)
            ->with(['category', 'brand'])
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)->get();

        return view('home', compact('featuredProducts', 'categories'));
    }

    public function products(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $query = Product::where('is_active', true)->where('in_stock', true);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('id_category', $request->category);
        }

        // Filter by brand
        if ($request->has('brand') && $request->brand) {
            $query->where('id_brand', $request->brand);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        if ($sort === 'price') {
            $query->orderBy('price', $direction);
        } else {
            $query->orderBy('name', $direction);
        }

        $products = $query->with(['category', 'brand'])->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        return view('products', compact('products', 'categories', 'brands'));
    }

    public function productDetail($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'brand'])
            ->firstOrFail();

        $relatedProducts = Product::where('id_category', $product->id_category)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('in_stock', true)
            ->take(4)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Get recent orders
        $recentOrders = Order::where('id_user', $user->id)
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get order statistics
        $totalOrders = Order::where('id_user', $user->id)->count();
        $totalSpent = Order::where('id_user', $user->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');
        $pendingOrders = Order::where('id_user', $user->id)
            ->whereIn('status', ['new', 'processing'])
            ->count();
        $deliveredOrders = Order::where('id_user', $user->id)
            ->where('status', 'delivered')
            ->count();

        return view('dashboard', compact(
            'recentOrders',
            'totalOrders',
            'totalSpent',
            'pendingOrders',
            'deliveredOrders'
        ));
    }
}
