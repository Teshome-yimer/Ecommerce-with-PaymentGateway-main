<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $cartCount = 0;
        
        if (Auth::check()) {
            $cartCount = Cart::where('id_user', Auth::id())->sum('quantity');
        } else {
            $cartCount = Cart::where('session_id', session()->getId())->sum('quantity');
        }
        
        View::share('cartCount', $cartCount);
        
        return $next($request);
    }
}
