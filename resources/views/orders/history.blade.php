@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-history me-2"></i>Order History</h2>
                <a href="{{ route('products') }}" class="btn btn-primary-custom">
                    <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                </a>
            </div>

            <!-- Filters -->
            <div class="card-clean mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('orders.history') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Order ID or Product name" 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Payment</label>
                            <select name="payment_status" class="form-select">
                                <option value="">All Payment</option>
                                @foreach($paymentStatusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ request('payment_status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">From Date</label>
                            <input type="date" name="date_from" class="form-control" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">To Date</label>
                            <input type="date" name="date_to" class="form-control" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                        <div class="mt-3">
                            <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times me-1"></i>Clear Filters
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Orders List -->
            @if($orders->count() > 0)
                <div class="row">
                    @foreach($orders as $order)
                    <div class="col-12 mb-4">
                        <div class="card-clean">
                            <div class="card-body">
                                <!-- Order Header -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-6">
                                        <h5 class="mb-1">
                                            <i class="fas fa-receipt me-2"></i>Order #{{ $order->id }}
                                        </h5>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'processing' ? 'warning' : ($order->status === 'canceled' ? 'danger' : 'primary')) }} me-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Order Items Preview -->
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($order->items->take(3) as $item)
                                                <div class="d-flex align-items-center bg-light rounded p-2">
                                                    @if($item->product && $item->product->images)
                                                        <img src="{{ Storage::url($item->product->images[0]) }}" 
                                                             class="rounded me-2" 
                                                             style="width: 40px; height: 40px; object-fit: cover;" 
                                                             alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" 
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-image text-white"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold small">{{ $item->product->name ?? 'Product Deleted' }}</div>
                                                        <div class="text-muted small">Qty: {{ $item->quantity }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 3)
                                                <div class="d-flex align-items-center">
                                                    <span class="text-muted">+{{ $order->items->count() - 3 }} more items</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <div class="h5 mb-0 text-primary">
                                            Birr {{ number_format($order->grand_total, 2, '.', ',') }}
                                        </div>
                                        <small class="text-muted">{{ $order->items->sum('quantity') }} items</small>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('orders.detail', $order) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </a>
                                    
                                    @if($order->payment_status === 'paid')
                                        <a href="{{ route('invoice.download', $order) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-download me-1"></i>Download Invoice
                                        </a>
                                    @endif
                                    
                                    @if(in_array($order->status, ['new', 'processing']))
                                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                                <i class="fas fa-times me-1"></i>Cancel Order
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($order->status === 'delivered')
                                        <form action="{{ route('orders.reorder', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-redo me-1"></i>Reorder
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                    </div>
                    <h4>No Orders Found</h4>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                            No orders match your current filters. Try adjusting your search criteria.
                        @else
                            You haven't placed any orders yet. Start shopping to see your order history here.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                            <a href="{{ route('orders.history') }}" class="btn btn-outline-primary">
                                <i class="fas fa-times me-2"></i>Clear Filters
                            </a>
                        @endif
                        <a href="{{ route('products') }}" class="btn btn-primary-custom">
                            <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .card-clean:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.2s ease;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }
        
        .d-flex.gap-2 > * {
            margin-bottom: 0.5rem;
        }
    }
</style>
@endpush
@endsection
