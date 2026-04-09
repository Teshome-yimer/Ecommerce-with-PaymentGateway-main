@extends('layouts.app')

@section('title', 'ክፍያ')

@section('content')
<div class="container my-4">
    <h2>ክፍያ</h2>
    <div class="row">
        <div class="col-lg-8">
            <form id="checkout-form">
                @csrf
                <div class="card mb-4">
                    <div class="card-header"><h5 class="mb-0">የመላኪያ መረጃ</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">የመጀመሪያ ስም *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">የአባት ስም *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">ስልክ ቁጥር *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="street_address" class="form-label">አድራሻ *</label>
                            <input type="text" class="form-control" id="street_address" name="street_address" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">ከተማ *</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">ክልል *</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">ሀገር *</label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">ሀገር ይምረጡ</option>
                                    <option value="Ethiopia" selected>ኢትዮጵያ</option>
                                    <option value="Eritrea">ኤርትራ</option>
                                    <option value="America">አሜሪካ</option>
                                    <option value="Russia">ሩሲያ</option>
                                    <option value="Iran">ኢራን</option>
                                    <option value="Indonesia">ኢንዶኔዥያ</option>
                                    <option value="Malaysia">ማሌዥያ</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip_code" class="form-label">ፖስታ ቁጥር *</label>
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
                                <!-- Chapa -->
                                <div class="col-md-6">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="chapa" value="chapa" checked>
                                        <label for="chapa" class="payment-label">
                                            <div class="payment-content">
                                                <img src="https://chapa.co/asset/images/chapa_logo.svg" alt="Chapa" style="height:36px;object-fit:contain;margin-bottom:8px;" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                                                <i class="fas fa-wallet fa-2x text-primary mb-2" style="display:none;"></i>
                                                <h6 class="mb-1">Chapa (Ethiopia)</h6>
                                                <div class="d-flex justify-content-center gap-1 flex-wrap mt-1">
                                                    <span style="background:#e8f5e9;color:#2e7d32;font-size:0.65rem;padding:2px 7px;border-radius:20px;font-weight:600;">Telebirr</span>
                                                    <span style="background:#e3f2fd;color:#1565c0;font-size:0.65rem;padding:2px 7px;border-radius:20px;font-weight:600;">CBEBirr</span>
                                                    <span style="background:#fff3e0;color:#e65100;font-size:0.65rem;padding:2px 7px;border-radius:20px;font-weight:600;">Cards</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Credit Card -->
                                <div class="col-md-6">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="credit_card" value="credit_card">
                                        <label for="credit_card" class="payment-label">
                                            <div class="payment-content">
                                                <div class="d-flex justify-content-center gap-2 mb-2">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" style="height:24px;object-fit:contain;">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" style="height:24px;object-fit:contain;">
                                                </div>
                                                <h6 class="mb-1">Credit/Debit Card</h6>
                                                <small class="text-muted">Visa, Mastercard</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Bank Transfer -->
                                <div class="col-md-6">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                        <label for="bank_transfer" class="payment-label">
                                            <div class="payment-content">
                                                <div class="d-flex justify-content-center gap-2 mb-2 flex-wrap">
                                                    <span style="background:#1565c0;color:#fff;font-size:0.7rem;padding:3px 8px;border-radius:6px;font-weight:700;">CBE</span>
                                                    <span style="background:#c62828;color:#fff;font-size:0.7rem;padding:3px 8px;border-radius:6px;font-weight:700;">Awash</span>
                                                    <span style="background:#2e7d32;color:#fff;font-size:0.7rem;padding:3px 8px;border-radius:6px;font-weight:700;">Dashen</span>
                                                </div>
                                                <h6 class="mb-1">Bank Transfer</h6>
                                                <small class="text-muted">CBE, Awash, Dashen & more</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- E-Wallet -->
                                <div class="col-md-6">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="ewallet" value="ewallet">
                                        <label for="ewallet" class="payment-label">
                                            <div class="payment-content">
                                                <div class="d-flex justify-content-center gap-1 flex-wrap mb-2">
                                                    <span style="background:#00897b;color:#fff;font-size:0.7rem;padding:3px 8px;border-radius:6px;font-weight:700;">Telebirr</span>
                                                    <span style="background:#1976d2;color:#fff;font-size:0.7rem;padding:3px 8px;border-radius:6px;font-weight:700;">HelloCash</span>
                                                </div>
                                                <h6 class="mb-1">Mobile Wallet</h6>
                                                <small class="text-muted">Telebirr, HelloCash</small>
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
                                    <small class="fw-bold">ደህንነቱ የተጠበቀ ክፍያ</small><br>
                                    <small class="text-muted">ክፍያዎ ምስጠራ ተደርጎ ተጠብቋል።</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">Powered by</small><br>
                            <span style="color: #00ADEE; font-weight: bold; font-size: 16px;">CHAPA</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">የትዕዛዝ ማጠቃለያ</h5></div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                            <small class="text-muted">ብዛት: {{ $item->quantity }} × Birr {{ number_format($item->unit_amount, 0) }}</small>
                        </div>
                        <span>Birr {{ number_format($item->total_amount, 0) }}</span>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-2"><span>ድምር:</span><span>Birr {{ number_format($total, 0) }}</span></div>
                    <div class="d-flex justify-content-between mb-2"><span>የመላኪያ ዋጋ:</span><span>Birr {{ number_format($shippingCost, 0) }}</span></div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3"><strong>ጠቅላላ:</strong><strong>Birr {{ number_format($grandTotal, 0) }}</strong></div>

                    <button type="button" class="btn btn-primary w-100" id="pay-button">
                        <i class="fas fa-wallet"></i> Chapa በኩል ክፈሉ
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Processing Overlay -->
<div id="payment-overlay" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,12,41,0.85);backdrop-filter:blur(6px);display:none;align-items:center;justify-content:center;flex-direction:column;">

    <!-- Loading State -->
    <div id="overlay-loading" style="text-align:center;color:#fff;">
        <div style="width:90px;height:90px;margin:0 auto 24px;position:relative;">
            <svg viewBox="0 0 90 90" style="width:90px;height:90px;animation:spin 1.2s linear infinite;">
                <circle cx="45" cy="45" r="38" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="6"/>
                <circle cx="45" cy="45" r="38" fill="none" stroke="#818cf8" stroke-width="6"
                        stroke-dasharray="80 160" stroke-linecap="round"/>
            </svg>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-lock" style="font-size:1.6rem;color:#818cf8;"></i>
            </div>
        </div>
        <h3 style="font-size:1.4rem;font-weight:800;margin-bottom:8px;">ትዕዛዝዎን በማረጋገጥ ላይ ነን</h3>
        <p style="color:rgba(255,255,255,0.65);font-size:0.92rem;">እባክዎ ይጠብቁ — ይህ ጥቂት ሰከንዶች ይወስዳል...</p>
        <div style="display:flex;justify-content:center;gap:6px;margin-top:20px;">
            <div style="width:8px;height:8px;border-radius:50%;background:#818cf8;animation:bounce 1.2s infinite 0s;"></div>
            <div style="width:8px;height:8px;border-radius:50%;background:#818cf8;animation:bounce 1.2s infinite 0.2s;"></div>
            <div style="width:8px;height:8px;border-radius:50%;background:#818cf8;animation:bounce 1.2s infinite 0.4s;"></div>
        </div>
    </div>

    <!-- Success State -->
    <div id="overlay-success" style="display:none;text-align:center;color:#fff;animation:popIn 0.5s ease;">
        <div style="width:90px;height:90px;background:linear-gradient(135deg,#16a34a,#22c55e);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 0 40px rgba(34,197,94,0.5);">
            <i class="fas fa-check" style="font-size:2.2rem;color:#fff;"></i>
        </div>
        <h3 style="font-size:1.5rem;font-weight:800;margin-bottom:8px;">ትዕዛዙ በትክክል ተልኳል! ✅</h3>
        <p style="color:rgba(255,255,255,0.7);font-size:0.92rem;">ወደ ክፍያ ገጽ እየተዛወሩ ነው...</p>
    </div>

</div>

@push('styles')
<style>
@keyframes spin { to { transform: rotate(360deg); } }
@keyframes bounce { 0%,80%,100%{ transform:scale(0.6);opacity:0.4; } 40%{ transform:scale(1);opacity:1; } }
@keyframes popIn { from{ transform:scale(0.5);opacity:0; } to{ transform:scale(1);opacity:1; } }
</style>
@endpush
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
            'chapa': '<i class="fas fa-wallet"></i> Chapa በኩል ክፈሉ',
            'credit_card': '<i class="fas fa-credit-card"></i> ካርድ በኩል ክፈሉ',
            'bank_transfer': '<i class="fas fa-university"></i> ባንክ ዝውውር',
            'ewallet': '<i class="fas fa-mobile-alt"></i> ሞባይል ዋሌት'
        };
        payButton.innerHTML = buttonText[paymentMethod] || 'Place Order & Pay';
    }
});

document.getElementById('pay-button').addEventListener('click', function () {
    const form = document.getElementById('checkout-form');
    if (!form.checkValidity()) { form.reportValidity(); return; }

    // Show loading overlay
    const overlay = document.getElementById('payment-overlay');
    overlay.style.display = 'flex';
    document.getElementById('overlay-loading').style.display = 'block';
    document.getElementById('overlay-success').style.display = 'none';

    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> በሂደት ላይ...';

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
            // Show success state briefly then redirect
            document.getElementById('overlay-loading').style.display = 'none';
            document.getElementById('overlay-success').style.display = 'block';

            setTimeout(() => {
                if (selectedMethod === 'chapa') {
                    window.location.href = data.checkout_url;
                } else {
                    snap.pay(data.snap_token, {
                        onSuccess: function() { window.location.href = data.success_url; },
                        onClose: function() { overlay.style.display = 'none'; location.reload(); }
                    });
                }
            }, 1800);
        } else {
            overlay.style.display = 'none';
            alert(data.error || 'ሂደቱ አልተሳካም');
            document.getElementById('pay-button').disabled = false;
            document.getElementById('pay-button').innerHTML = '<i class="fas fa-wallet"></i> Chapa በኩል ክፈሉ';
        }
    })
    .catch(() => {
        overlay.style.display = 'none';
        document.getElementById('pay-button').disabled = false;
        document.getElementById('pay-button').innerHTML = '<i class="fas fa-wallet"></i> Chapa በኩል ክፈሉ';
    });
});
</script>
@endpush
@endsection