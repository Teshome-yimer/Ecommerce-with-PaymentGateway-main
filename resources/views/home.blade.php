@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-simple">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Welcome Unversal Shop</h1>
                <p class="lead mb-4">
                    Discover amazing products at great prices. Shop now and enjoy fast delivery!
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Shop Now
                    </a>
                    <a href="#featured" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-star me-2"></i>Featured
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                     class="img-fluid rounded" alt="Hero Image">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Shop by Category</h2>
            <p class="text-muted">Explore our product categories</p>
        </div>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card-clean h-100 text-center">
                    <div class="card-body">
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}"
                                 class="rounded-circle mb-3"
                                 style="width: 60px; height: 60px; object-fit: cover;"
                                 alt="{{ $category->name }}">
                        @else
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-tag fa-lg text-white"></i>
                            </div>
                        @endif
                        <h6 class="card-title">{{ $category->name }}</h6>
                        <a href="{{ route('products', ['category' => $category->id]) }}"
                           class="btn btn-primary-custom btn-sm">
                            Browse
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5" id="featured">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Featured Products</h2>
            <p class="text-muted">Discover our best products</p>
        </div>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card-clean h-100">
                    @if($product->on_sale)
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">Sale</span>
                        </div>
                    @endif

                    @if($product->images && count($product->images) > 0)
                        <img src="{{ Storage::url($product->images[0]) }}"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;"
                             alt="{{ $product->name }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="text-muted small">{{ $product->category->name }} • {{ $product->brand->name }}</p>
                        <p class="card-text">{{ Str::limit($product->description, 80) }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="price-simple">Birr {{ number_format($product->price, 2, ','.',') }}</span>
                            @if($product->in_stock)
                                <span class="badge bg-success">In Stock</span>
                            @else
                                <span class="badge bg-secondary">Out of Stock</span>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <button onclick="addToCart({{ $product->id }})"
                                    class="btn btn-primary-custom btn-sm"
                                    {{ !$product->in_stock ? 'disabled' : '' }}>
                                <i class="fas fa-cart-plus me-1"></i>Add to Cart
                            </button>
                            <a href="{{ route('product.detail', $product->slug) }}"
                               class="btn btn-outline-secondary btn-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('products') }}" class="btn btn-primary-custom btn-lg">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Why Choose Us</h2>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-shipping-fast fa-lg text-white"></i>
                    </div>
                    <h6>Fast Delivery</h6>
                    <p class="text-muted">Quick and reliable delivery to your doorstep</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-shield-alt fa-lg text-white"></i>
                    </div>
                    <h6>Secure Payment</h6>
                    <p class="text-muted">Your payment information is safe and secure</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-headset fa-lg text-white"></i>
                    </div>
                    <h6>24/7 Support</h6>
                    <p class="text-muted">We're here to help you anytime, anywhere</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
