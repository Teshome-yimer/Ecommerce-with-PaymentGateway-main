@extends('layouts.app')

@section('title', 'Order Successful')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                <h1 class="h2">Order Placed Successfully!</h1>
                <p class="lead text-muted">Thank you for your purchase. Your order has been received and is being processed.</p>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Order Number:</strong></div>
                        <div class="col-sm-9">#{{ $order->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Order Date:</strong></div>
                        <div class="col-sm-9">{{ $order->created_at->format('F d, Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Payment Status:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Order Status:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><strong>Total Amount:</strong></div>
                        <div class="col-sm-9"><strong>ETB {{ number_format($order->grand_total, 0, ',', '.') }}</strong></div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Ordered Items</h5>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="row align-items-center border-bottom py-3">
                        <div class="col-md-2">
                            @if($item->product->images && count($item->product->images) > 0)
                                <img src="{{ Storage::url($item->product->images[0]) }}" class="img-fluid rounded" style="height: 60px; object-fit: cover;" alt="{{ $item->product->name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                            <small class="text-muted">{{ $item->product->category->name }} • {{ $item->product->brand->name }}</small>
                        </div>
                        <div class="col-md-2 text-center">
                            <span>Qty: {{ $item->quantity }}</span>
                        </div>
                        <div class="col-md-2 text-end">
                            <span>ETB {{ number_format($item->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="row mt-3">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>ETB {{ number_format($order->grand_total - $order->shipping_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>ETB {{ number_format($order->shipping_amount, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong>ETB {{ number_format($order->grand_total, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($order->address)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Shipping Address</h5>
                </div>
                <div class="card-body">
                    <address>
                        <strong>{{ $order->address->first_name }} {{ $order->address->last_name }}</strong><br>
                        {{ $order->address->street_address }}<br>
                        {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}<br>
                        {{ $order->address->country }}<br>
                        <abbr title="Phone">P:</abbr> {{ $order->address->phone }}
                    </address>
                </div>
            </div>
            @endif

            <div class="alert alert-info mt-4">
                <h6><i class="fas fa-info-circle"></i> What's Next?</h6>
                <ul class="mb-0">
                    <li>You will receive an email confirmation shortly</li>
                    <li>We'll notify you when your order is shipped</li>
                    <li>Track your order status in your account</li>
                    <li>Contact us if you have any questions</li>
                </ul>
            </div>

            <div class="text-center mt-4">
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="{{ route('invoice.download', $order) }}" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Download Invoice
                    </a>
                    <a href="{{ route('invoice.preview', $order) }}" class="btn btn-outline-info">
                        <i class="fas fa-eye me-2"></i>View Invoice
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Continue Shopping
                    </a>
                    <a href="{{ route('orders.history') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>View My Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
