@extends('layouts.app')

@section('title', 'Invoice Preview')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Invoice Preview</h2>
                <div class="btn-group">
                    <a href="{{ route('invoice.download', $order) }}" class="btn btn-primary-custom">
                        <i class="fas fa-download me-2"></i>Download PDF
                    </a>
                    <a href="{{ route('invoice.view', $order) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>Open PDF
                    </a>
                    <a href="{{ route('checkout.success', $order) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Order
                    </a>
                </div>
            </div>

            <!-- Invoice Content -->
            <div class="card-clean">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-md-6">
                            <h3 class="text-primary fw-bold">የኛ ገበያ</h3>
                            <p class="mb-1">Wollo, Ethiopia</p>
                            <p class="mb-1">Phone: +251 962868748</p>
                            <p class="mb-0">Email: teshe@universityshop.com</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h4 class="fw-bold mb-3">INVOICE</h4>
                            <p class="mb-1"><strong>Invoice #:</strong> {{ $order->id }}</p>
                            <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                            <p class="mb-0"><strong>Due Date:</strong> {{ $order->created_at->addDays(30)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="bg-light p-3 rounded">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Order Status:</strong>
                                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'processing' ? 'warning' : 'primary') }} ms-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Payment Status:</strong>
                                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }} ms-2">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Payment Method:</strong>
                                        {{ $order->payment_method ?? 'Not specified' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing & Shipping -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Bill To:</h6>
                            <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                            <p class="mb-0">{{ $order->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Ship To:</h6>
                            @if($order->address)
                                <p class="mb-1"><strong>{{ $order->address->first_name }} {{ $order->address->last_name }}</strong></p>
                                <p class="mb-1">{{ $order->address->street_address }}</p>
                                <p class="mb-1">{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}</p>
                                <p class="mb-1">{{ $order->address->country }}</p>
                                <p class="mb-0">Phone: {{ $order->address->phone }}</p>
                            @else
                                <p class="text-muted">No shipping address provided</p>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width: 50%">Product</th>
                                    <th style="width: 15%" class="text-center">Qty</th>
                                    <th style="width: 20%" class="text-end">Unit Price</th>
                                    <th style="width: 15%" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product->name }}</strong>
                                        @if($item->product->category)
                                            <br><small class="text-muted">Category: {{ $item->product->category->name }}</small>
                                        @endif
                                        @if($item->product->brand)
                                            <br><small class="text-muted">Brand: {{ $item->product->brand->name }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Birr {{ number_format($item->unit_amount, 2, '.', ',') }}</td>
                                    <td class="text-end">Birr {{ number_format($item->total_amount, 2, ','. ',') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Subtotal:</strong></td>
                                    <td class="text-end">Birr {{ number_format($order->items->sum('total_amount'), 2, '.', ',') }}</td>
                                </tr>
                                @if($order->shipping_amount)
                                <tr>
                                    <td><strong>Shipping:</strong></td>
                                    <td class="text-end">Birr {{ number_format($order->shipping_amount, 2, '.', ',') }}</td>
                                </tr>
                                @endif
                                <tr class="table-primary">
                                    <td><strong>Total:</strong></td>
                                    <td class="text-end"><strong>Birr {{ number_format($order->grand_total, 2, '.', ',') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-5 pt-4 border-top">
                        <p class="fw-bold">Thank you for your business!</p>
                        <p class="text-muted">This is a computer-generated invoice. No signature required.</p>
                        <p class="text-muted">For any questions regarding this invoice, please contact us at teshe@universityshop.com <br>የኛ ገበያ - Your trusted online shopping destination</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .btn-group, .navbar, .footer {
            display: none !important;
        }

        .container {
            max-width: 100% !important;
            padding: 0 !important;
        }

        .card-clean {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
@endsection
