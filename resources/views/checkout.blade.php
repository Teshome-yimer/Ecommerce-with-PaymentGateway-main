@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container my-4">
    <h2>Checkout</h2>

    <div class="row">
        <div class="col-lg-8">
            <form id="checkout-form">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="street_address" class="form-label">Street Address *</label>
                            <input type="text" class="form-control" id="street_address" name="street_address" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State/Province *</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="Ethiopia" selected>Ethiopia</option>
                                    <option value="Eritrea">Ertirea</option>
                                    <option value="America">America</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Iran"> Iran</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Malaysia">Malaysia</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip_code" class="form-label">ZIP/Postal Code *</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="payment-methods">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="chapa" value="chapa" checked>
                                        <label for="chapa" class="payment-label">
                                            <div class="payment-content">
                                                <i class="fas fa-wallet fa-2x text-primary mb-2"></i>
                                                <h6 class="mb-1">Chapa (Ethiopia)</h6>
                                                <small class="text-muted">Telebirr, CBEBirr, Cards</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="credit_card" value="credit_card">
                                        <label for="credit_card" class="payment-label">
                                            <div class="payment-content">
                                                <i class="fas fa-credit-card fa-2x text-primary mb-2"></i>
                                                <h6 class="mb-1">Credit/Debit Card</h6>
                                                <small class="text-muted">Visa, Mastercard, JCB</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                        <label for="bank_transfer" class="payment-label">
                                            <div class="payment-content">
                                                <i class="fas fa-university fa-2x text-success mb-2"></i>
                                                <h6 class="mb-1">Bank Transfer</h6>
                                                <small class="text-muted">BCA, BNI, BRI, Mandiri</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="ewallet" value="ewallet">
                                        <label for="ewallet" class="payment-label">
                                            <div class="payment-content">
                                                <i class="fas fa-mobile-alt fa-2x text-warning mb-2"></i>
                                                <h6 class="mb-1">E-Wallet</h6>
                                                <small class="text-muted">GoPay, OVO, DANA</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-light mt-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shield-alt text-success me-2"></i>
                                <div>
                                    <small class="fw-bold">Secure Payment</small><br>
                                    <small class="text-muted">Your payment is encrypted and protected.</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">Powered by</small><br>
                            <span style="color: #00ADEE; font-weight: bold; font-size: 16px;">CHAPA</span>
                            <span class="mx-2">|</span>
                            <span style="color: #0077B6; font-weight: bold; font-size: 16px;">MIDTRANS</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                            <small class="text-muted">Qty: {{ $item->quantity }} × ETB {{ number_format($item->unit_amount, 2) }}</small>
                        </div>
                        <span>ETB {{ number_format($item->total_amount, 2) }}</span>
                    </div>
                    @endforeach

                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>ETB {{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>ETB {{ number_format($shippingCost, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong>ETB {{ number_format($grandTotal, 2) }}</strong>
                    </div>

                    <button type="button" class="btn btn-primary w-100" id="pay-button">
                        <i class="fas fa-wallet"></i> Pay with Chapa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .payment-option { position: relative; height: 100%; }
    .payment-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .payment-label {
        display: block; width: 100%; height: 100%; padding: 1rem;
        border: 2px solid #e3e6f0; border-radius: 0.5rem; cursor: pointer;
        transition: all 0.3s ease; background: white;
    }
    .payment-label:hover { border-color: #667eea; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15); }
    .payment-option input[type="radio"]:checked + .payment-label {
        border-color: #667eea; background: rgba(102, 126, 234, 0.05);
    }
    .payment-content { text-align: center; }
</style>
@endpush

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
    const payButton = document.getElementById('pay-button');

    paymentOptions.forEach(option => {
        option.addEventListener('change', function() {
            updatePayButton(this.value);
        });
    });

    function updatePayButton(paymentMethod) {
        const buttonText = {
            'chapa': '<i class="fas fa-wallet"></i> Pay with Chapa',
            'credit_card': '<i class="fas fa-credit-card"></i> Pay with Card',
            'bank_transfer': '<i class="fas fa-university"></i> Pay with Bank Transfer',
            'ewallet': '<i class="fas fa-mobile-alt"></i> Pay with E-Wallet'
        };
        payButton.innerHTML = buttonText[paymentMethod] || 'Place Order & Pay';
    }
});

document.getElementById('pay-button').addEventListener('click', function () {
    const form = document.getElementById('checkout-form');
    if (!form.checkValidity()) { form.reportValidity(); return; }

    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

    const formData = new FormData(form);
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

    fetch('{{ route("checkout.process") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (selectedMethod === 'chapa') {
                // Redirect to Chapa Payment URL
                window.location.href = data.checkout_url;
            } else {
                // Midtrans Logic
                snap.pay(data.snap_token, {
                    onSuccess: function(result) { window.location.href = data.success_url; },
                    onClose: function() { location.reload(); }
                });
            }
        } else {
            alert(data.error || 'Process failed');
            this.disabled = false;
        }
    });
});
</script>
@endpush
@endsection