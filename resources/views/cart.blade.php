@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container my-4">
    <h2>Shopping Cart</h2>

    @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="row align-items-center border-bottom py-3" id="cart-item-{{ $item->id }}">
                            <div class="col-md-2">
                                @if($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ Storage::url($item->product->images[0]) }}" class="img-fluid rounded" style="height: 80px; object-fit: cover;" alt="{{ $item->product->name }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <small class="text-muted">{{ $item->product->category->name }} • {{ $item->product->brand->name }}</small>
                                <div class="mt-1">
                                    <span class="text-primary">Birr {{ number_format($item->unit_amount, 0, '.', ',') }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="width: 120px;">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">-</button>
                                    <input type="number" class="form-control form-control-sm text-center" value="{{ $item->quantity }}" min="1" id="qty-{{ $item->id }}" onchange="updateQuantity({{ $item->id }}, this.value)">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <span class="fw-bold" id="item-total-{{ $item->id }}">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-outline-danger btn-sm" onclick="removeItem({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-outline-danger" onclick="clearCart()">
                        <i class="fas fa-trash"></i> Clear Cart
                    </button>
                    <a href="{{ route('products') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="cart-subtotal">Birr {{ number_format($total, 0, '.', ',') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>Birr 15,000</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong id="cart-total">Birr {{ number_format($total + 15000, 0, '.', ',') }}</strong>
                        </div>

                        @auth
                            <a href="{{ route('checkout') }}" class="btn btn-primary w-100">
                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                            </a>
                        @else
                            <div class="text-center mb-3">
                                <p class="text-muted">Please login to checkout</p>
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>
                                <div class="mt-2">
                                    <small>Don't have an account? <a href="{{ route('register') }}">Register here</a></small>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Security Features -->
                <div class="card mt-3">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-4">
                                <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                                <div class="small">Secure</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-lock fa-2x text-success mb-2"></i>
                                <div class="small">Encrypted</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-credit-card fa-2x text-success mb-2"></i>
                                <div class="small">Safe Payment</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag"></i> Start Shopping
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
function updateQuantity(itemId, quantity) {
    if (quantity < 1) {
        removeItem(itemId);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: `/cart/${itemId}`,
        method: 'PUT',
        data: { quantity: quantity },
        success: function(response) {
            if (response.success) {
                $(`#qty-${itemId}`).val(quantity);
                $(`#item-total-${itemId}`).text('Rp ' + new Intl.NumberFormat('id-ID').format(response.item_total));
                $('#cart-subtotal').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.cart_total));
                $('#cart-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.cart_total + 15000));
            }
        },
        error: function(xhr) {
            showAlert('danger', 'Failed to update quantity');
        }
    });
}

function removeItem(itemId) {
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: `/cart/${itemId}`,
        method: 'DELETE',
        success: function(response) {
            if (response.success) {
                $(`#cart-item-${itemId}`).remove();
                $('#cart-count').text(response.cart_count);
                $('#cart-subtotal').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.cart_total));
                $('#cart-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.cart_total + 15000));

                if (response.cart_count === 0) {
                    location.reload();
                }
            }
        },
        error: function(xhr) {
            showAlert('danger', 'Failed to remove item');
        }
    });
}

function clearCart() {
    if (!confirm('Are you sure you want to clear your cart?')) {
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/cart',
        method: 'DELETE',
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function(xhr) {
            showAlert('danger', 'Failed to clear cart');
        }
    });
}
</script>
@endpush
@endsection
