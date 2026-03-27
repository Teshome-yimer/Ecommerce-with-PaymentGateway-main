@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ Auth::user()->name }}!</h4>
                    <p>You are logged in! Here you can manage your account and view your orders.</p>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-shopping-bag fa-3x text-primary mb-3"></i>
                                    <h5>Browse Products</h5>
                                    <p class="text-muted">Discover our amazing products</p>
                                    <a href="{{ route('products') }}" class="btn btn-primary">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                                    <h5>View Cart</h5>
                                    <p class="text-muted">Check your shopping cart</p>
                                    <a href="{{ route('cart') }}" class="btn btn-success">View Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Quick Actions</div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('products') }}" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i> Browse Products
                        </a>
                        <a href="{{ route('cart') }}" class="btn btn-outline-success">
                            <i class="fas fa-shopping-cart"></i> View Cart
                        </a>
                        <a href="{{ route('orders.history') }}" class="btn btn-outline-info">
                            <i class="fas fa-list"></i> My Orders
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user-cog"></i> Profile Settings
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Account Info</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Member Since:</strong> {{ Auth::user()->created_at->format('F Y') }}</p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="fw-bold text-primary">{{ $totalOrders ?? 0 }}</div>
                            <small class="text-muted">Total Orders</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success">Birr {{ number_format($totalSpent ?? 2, 2, ','. ',') }}</div>
                            <small class="text-muted">Total Spent</small>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($recentOrders) && $recentOrders->count() > 0)
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Orders</span>
                    <a href="{{ route('orders.history') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="card-body p-0">
                    @foreach($recentOrders->take(3) as $order)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div class="me-3">
                            <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'processing' ? 'warning' : 'primary') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">#{{ $order->id }}</div>
                            <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">Birr {{ number_format($order->grand_total, 2, '.', ',') }}</div>
                            <a href="{{ route('orders.detail', $order) }}" class="btn btn-outline-primary btn-sm">View</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
