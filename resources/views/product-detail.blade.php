@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">ቤት</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">ምርቶች</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products', ['category' => $product->category->id]) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            @if($product->images && count($product->images) > 0)
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->images as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ str_starts_with($image, 'http') ? $image : Storage::url($image) }}" class="d-block w-100 rounded" style="height: 400px; object-fit: cover;" alt="{{ $product->name }}">
                        </div>
                        @endforeach
                    </div>
                    @if(count($product->images) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    @endif
                </div>

                @if(count($product->images) > 1)
                <div class="row mt-3">
                    @foreach($product->images as $index => $image)
                    <div class="col-3">
                        <img src="{{ str_starts_with($image, 'http') ? $image : Storage::url($image) }}" class="img-thumbnail" style="height: 80px; object-fit: cover; cursor: pointer;"
                             onclick="$('#productCarousel').carousel({{ $index }})" alt="{{ $product->name }}">
                    </div>
                    @endforeach
                </div>
                @endif
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-image fa-5x text-muted"></i>
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <h1 class="h2">{{ $product->name }}</h1>

            <div class="mb-3">
                <span class="text-muted">ምድብ: </span>
                <a href="{{ route('products', ['category' => $product->category->id]) }}" class="text-decoration-none">{{ $product->category->name }}</a>
                <span class="text-muted mx-2">•</span>
                <span class="text-muted">ብራንድ: </span>
                <a href="{{ route('products', ['brand' => $product->brand->id]) }}" class="text-decoration-none">{{ $product->brand->name }}</a>
            </div>

            <div class="mb-3">
                @if($product->is_featured)
                    <span class="badge bg-warning text-dark me-2">ምርጥ</span>
                @endif
                @if($product->on_sale)
                    <span class="badge bg-danger me-2">ቅናሽ</span>
                @endif
                @if($product->in_stock)
                    <span class="badge bg-success">አለ</span>
                @else
                    <span class="badge bg-secondary">የለም</span>
                @endif
            </div>

            <div class="mb-4">
                <span class="h3 text-primary">Birr {{ number_format($product->price, 2, '.', ',') }}</span>
            </div>

            @if($product->description)
            <div class="mb-4">
                <h5>ዝርዝር መግለጫ</h5>
                <div class="text-muted">{!! nl2br(e($product->description)) !!}</div>
            </div>
            @endif

            @if($product->in_stock)
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-auto"><label for="quantity" class="form-label">ብዛት:</label></div>
                    <div class="col-auto"><input type="number" id="quantity" class="form-control" value="1" min="1" max="10" style="width: 80px;"></div>
                    <div class="col">
                        <button onclick="addToCartWithQuantity({{ $product->id }})" class="btn btn-primary btn-lg">
                            <i class="fas fa-cart-plus"></i> ጋሪ ጨምር
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> ይህ ምርት አሁን አይገኝም።
            </div>
            @endif

            <div class="row text-center mt-4">
                <div class="col-4"><i class="fas fa-shipping-fast fa-2x text-primary mb-2"></i><div class="small">ፈጣን ማድረስ</div></div>
                <div class="col-4"><i class="fas fa-shield-alt fa-2x text-primary mb-2"></i><div class="small">ደህንነቱ የተጠበቀ</div></div>
                <div class="col-4"><i class="fas fa-undo fa-2x text-primary mb-2"></i><div class="small">ቀላል መመለስ</div></div>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3>ተዛማጅ ምርቶች</h3>
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    @if($relatedProduct->images && count($relatedProduct->images) > 0)
                        <img src="{{ str_starts_with($relatedProduct->images[0], 'http') ? $relatedProduct->images[0] : Storage::url($relatedProduct->images[0]) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $relatedProduct->name }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;"><i class="fas fa-image fa-3x text-muted"></i></div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                        <p class="text-muted small">{{ $relatedProduct->brand->name }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h6 text-primary mb-0">Birr {{ number_format($relatedProduct->price, 0, '.', ',') }}</span>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('product.detail', $relatedProduct->slug) }}" class="btn btn-outline-primary btn-sm">ዝርዝር</a>
                                <button onclick="addToCart({{ $relatedProduct->id }})" class="btn btn-primary btn-sm">ጋሪ ጨምር</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function addToCartWithQuantity(productId) {
    const quantity = document.getElementById('quantity').value;
    addToCart(productId, parseInt(quantity));
}
</script>
@endpush
@endsection
