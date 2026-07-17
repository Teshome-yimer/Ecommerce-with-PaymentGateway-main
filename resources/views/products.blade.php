@extends('layouts.app')
@section('title', 'ምርቶች')

@push('styles')
<style>
.products-page { background: #f8f7ff; min-height: 100vh; padding: 40px 0; }

/* Sidebar */
.filter-card {
    background: #fff;
    border-radius: 20px;
    padding: 28px 22px;
    box-shadow: 0 4px 20px rgba(99,102,241,0.08);
    border: none;
    position: sticky;
    top: 20px;
}
.filter-title {
    font-size: 1.1rem; font-weight: 800; color: #1e1b4b;
    margin-bottom: 22px; display: flex; align-items: center; gap: 8px;
}
.filter-label { font-size: 0.78rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
.filter-input {
    width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb;
    border-radius: 10px; font-size: 0.88rem; color: #1e1b4b;
    background: #f9fafb; outline: none; transition: all 0.2s;
}
.filter-input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
.filter-section { margin-bottom: 20px; }
.btn-filter {
    width: 100%; padding: 11px; border: none; border-radius: 10px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-weight: 700; font-size: 0.9rem; cursor: pointer;
    transition: all 0.3s; box-shadow: 0 4px 15px rgba(99,102,241,0.3);
}
.btn-filter:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(99,102,241,0.4); }
.btn-clear {
    width: 100%; padding: 10px; border: 1.5px solid #e5e7eb; border-radius: 10px;
    background: #fff; color: #6b7280; font-weight: 600; font-size: 0.88rem;
    cursor: pointer; transition: all 0.2s; margin-top: 8px; text-decoration: none;
    display: block; text-align: center;
}
.btn-clear:hover { border-color: #6366f1; color: #6366f1; }

/* Page header */
.products-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 28px; flex-wrap: wrap; gap: 12px;
}
.products-title { font-size: 1.8rem; font-weight: 800; color: #1e1b4b; margin: 0; }
.products-count {
    background: #eef2ff; color: #6366f1; font-size: 0.82rem;
    font-weight: 700; padding: 6px 14px; border-radius: 50px;
}

/* Product card */
.product-card {
    background: #fff; border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 2px solid transparent;
    transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
    position: relative; height: 100%;
}
.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(99,102,241,0.18);
    border-color: #6366f1;
}
.product-img-wrap { position: relative; overflow: hidden; height: 210px; }
.product-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.product-card:hover .product-img-wrap img { transform: scale(1.07); }
.product-overlay {
    position: absolute; inset: 0; background: rgba(99,102,241,0.82);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.3s;
}
.product-card:hover .product-overlay { opacity: 1; }
.badge-sale {
    position: absolute; top: 12px; left: 12px;
    background: linear-gradient(135deg, #ef4444, #f97316);
    color: #fff; font-size: 0.68rem; font-weight: 700;
    padding: 4px 10px; border-radius: 50px; text-transform: uppercase; z-index: 1;
}
.badge-featured {
    position: absolute; top: 12px; right: 12px;
    background: linear-gradient(135deg, #f59e0b, #f97316);
    color: #fff; font-size: 0.68rem; font-weight: 700;
    padding: 4px 10px; border-radius: 50px; z-index: 1;
}
.product-body { padding: 16px 18px 18px; }
.product-cat { font-size: 0.72rem; color: #6366f1; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
.product-name { font-weight: 700; color: #1e1b4b; font-size: 0.98rem; margin: 5px 0 6px; line-height: 1.3; }
.product-desc { font-size: 0.8rem; color: #9ca3af; margin-bottom: 12px; line-height: 1.5; }
.product-price { font-size: 1.15rem; font-weight: 800; color: #6366f1; }
.stock-badge-in { background: #dcfce7; color: #16a34a; font-size: 0.68rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
.stock-badge-out { background: #fee2e2; color: #dc2626; font-size: 0.68rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
.btn-view {
    flex: 1; padding: 9px; border: 1.5px solid #6366f1; border-radius: 10px;
    color: #6366f1; font-weight: 600; font-size: 0.82rem; background: #fff;
    text-align: center; text-decoration: none; transition: all 0.2s;
}
.btn-view:hover { background: #6366f1; color: #fff; }
.btn-cart {
    flex: 1; padding: 9px; border: none; border-radius: 10px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-weight: 600; font-size: 0.82rem; cursor: pointer;
    transition: all 0.2s;
}
.btn-cart:hover { box-shadow: 0 6px 16px rgba(99,102,241,0.4); transform: translateY(-1px); }
.btn-cart:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

/* Empty state */
.empty-state { text-align: center; padding: 80px 20px; }
.empty-icon { width: 90px; height: 90px; background: #eef2ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }

/* Pagination */
.pagination .page-link { border-radius: 8px !important; margin: 0 2px; border: none; color: #6366f1; font-weight: 600; }
.pagination .page-item.active .page-link { background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; }
</style>
@endpush

@section('content')
<div class="products-page">
    <div class="container">
        <div class="row g-4">

            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="filter-card">
                    <div class="filter-title">
                        <i class="fas fa-sliders-h" style="color:#6366f1;"></i> ማጣሪያ
                    </div>
                    <form method="GET" action="{{ route('products') }}">

                        <div class="filter-section">
                            <div class="filter-label">ፈልግ</div>
                            <input type="text" name="search" class="filter-input" value="{{ request('search') }}" placeholder="ምርት ፈልግ...">
                        </div>

                        <div class="filter-section">
                            <div class="filter-label">ምድብ</div>
                            <select name="category" class="filter-input">
                                <option value="">ሁሉም ምድቦች</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-section">
                            <div class="filter-label">ብራንድ</div>
                            <select name="brand" class="filter-input">
                                <option value="">ሁሉም ብራንዶች</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-section">
                            <div class="filter-label">ደርድር</div>
                            <select name="sort" class="filter-input mb-2">
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>በስም</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>በዋጋ</option>
                            </select>
                            <select name="direction" class="filter-input">
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>ከትንሽ ወደ ትልቅ</option>
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>ከትልቅ ወደ ትንሽ</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search me-2"></i>ማጣሪያ ተጠቀም
                        </button>
                        <a href="{{ route('products') }}" class="btn-clear">
                            <i class="fas fa-times me-1"></i>አጽዳ
                        </a>
                    </form>
                </div>
            </div>

            <!-- Products -->
            <div class="col-lg-9">
                <div class="products-header">
                    <h1 class="products-title">ምርቶች</h1>
                    <span class="products-count">
                        <i class="fas fa-box me-1"></i>{{ $products->total() }} ምርቶች ተገኝተዋል
                    </span>
                </div>

                @if($products->count() > 0)
                    <div class="row g-4">
                        @foreach($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="product-card">
                                @if($product->on_sale)<div class="badge-sale">ቅናሽ</div>@endif
                                @if($product->is_featured)<div class="badge-featured">⭐ ምርጥ</div>@endif

                                <div class="product-img-wrap">
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ $product->first_image }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="product-overlay">
                                        <a href="{{ route('product.detail', $product->slug) }}"
                                           class="btn btn-light btn-sm rounded-pill px-4">
                                            <i class="fas fa-eye me-1"></i> ዝርዝር ይመልከቱ
                                        </a>
                                    </div>
                                </div>

                                <div class="product-body">
                                    <div class="product-cat">{{ $product->category->name }} • {{ $product->brand->name }}</div>
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-desc">{{ Str::limit($product->description, 75) }}</div>

                                    <div class="d-flex justify-content-between align-items-center mb-12" style="margin-bottom:12px;">
                                        <span class="product-price">Birr {{ number_format($product->price, 0, '.', ',') }}</span>
                                        @if($product->in_stock)
                                            <span class="stock-badge-in">✓ አለ</span>
                                        @else
                                            <span class="stock-badge-out">✗ የለም</span>
                                        @endif
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('product.detail', $product->slug) }}" class="btn-view">
                                            ዝርዝር
                                        </a>
                                        <button onclick="addToCart({{ $product->id }})"
                                                class="btn-cart" {{ !$product->in_stock ? 'disabled' : '' }}>
                                            <i class="fas fa-cart-plus me-1"></i>ይጨምሩ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-search fa-2x" style="color:#6366f1;"></i>
                        </div>
                        <h4 style="color:#1e1b4b;font-weight:700;">ምርት አልተገኘም</h4>
                        <p style="color:#9ca3af;">የፍለጋ መስፈርቱን ቀይረው እንደገና ይሞክሩ።</p>
                        <a href="{{ route('products') }}" class="btn-filter d-inline-block px-5" style="width:auto;border-radius:50px;">
                            ሁሉንም ምርቶች ይመልከቱ
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
