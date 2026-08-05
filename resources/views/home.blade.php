@extends('layouts.app')

@section('title', 'Home')

@push('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    min-height: 92vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.hero-section::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(99,102,241,0.3) 0%, transparent 70%);
    top: -100px; right: -100px;
    border-radius: 50%;
    animation: pulse-glow 4s ease-in-out infinite;
}
.hero-section::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(236,72,153,0.2) 0%, transparent 70%);
    bottom: -80px; left: -80px;
    border-radius: 50%;
    animation: pulse-glow 5s ease-in-out infinite reverse;
}
@keyframes pulse-glow {
    0%, 100% { transform: scale(1); opacity: 0.7; }
    50% { transform: scale(1.15); opacity: 1; }
}
.hero-badge {
    display: inline-block;
    background: rgba(99,102,241,0.2);
    border: 1px solid rgba(99,102,241,0.5);
    color: #a5b4fc;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 0.8rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    animation: fadeInDown 0.8s ease;
}
.hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    animation: fadeInUp 0.9s ease;
}
.hero-title span {
    background: linear-gradient(90deg, #818cf8, #ec4899, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-subtitle { color: rgba(255,255,255,0.7); font-size: 1.1rem; animation: fadeInUp 1s ease; }
.hero-btn-primary {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none; color: #fff;
    padding: 14px 32px; border-radius: 50px;
    font-weight: 600; font-size: 1rem;
    transition: all 0.3s;
    box-shadow: 0 8px 25px rgba(99,102,241,0.4);
}
.hero-btn-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(99,102,241,0.6); color: #fff; }
.hero-btn-outline {
    background: transparent;
    border: 2px solid rgba(255,255,255,0.3);
    color: #fff; padding: 14px 32px; border-radius: 50px; font-weight: 600; transition: all 0.3s;
}
.hero-btn-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.6); color: #fff; transform: translateY(-3px); }
.hero-image-wrap { position: relative; animation: floatUp 1.2s ease; }
.hero-image-wrap img { border-radius: 24px; box-shadow: 0 30px 80px rgba(0,0,0,0.5); }
.hero-float-card {
    position: absolute;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 16px; padding: 12px 18px; color: #fff; font-size: 0.85rem;
    animation: float 3s ease-in-out infinite;
}
.hero-float-card.card-1 { top: 20px; left: -30px; animation-delay: 0s; }
.hero-float-card.card-2 { bottom: 30px; right: -20px; animation-delay: 1.5s; }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.stats-bar { background: linear-gradient(135deg, #6366f1, #8b5cf6); padding: 20px 0; }
.stat-item { text-align: center; color: #fff; }
.stat-number { font-size: 1.8rem; font-weight: 800; }
.stat-label { font-size: 0.8rem; opacity: 0.85; text-transform: uppercase; letter-spacing: 1px; }
.section-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: #6366f1; font-weight: 600; }
.section-heading { font-size: 2rem; font-weight: 800; color: #1e1b4b; }
.category-card {
    background: #fff; border-radius: 20px; padding: 28px 20px; text-align: center;
    border: 2px solid transparent; transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}
.category-card:hover { border-color: #6366f1; transform: translateY(-8px); box-shadow: 0 20px 50px rgba(99,102,241,0.15); }
.category-icon {
    width: 70px; height: 70px;
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px; transition: all 0.3s;
}
.category-card:hover .category-icon { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.category-name { font-weight: 700; color: #1e1b4b; margin-bottom: 8px; }
.category-browse { font-size: 0.8rem; color: #6366f1; font-weight: 600; text-decoration: none; }
.product-card {
    background: #fff; border-radius: 20px; overflow: hidden; border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    transition: all 0.35s cubic-bezier(0.4,0,0.2,1); position: relative;
}
.product-card:hover { transform: translateY(-10px); box-shadow: 0 25px 60px rgba(99,102,241,0.18); }
.product-img-wrap { position: relative; overflow: hidden; height: 220px; }
.product-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.product-card:hover .product-img-wrap img { transform: scale(1.08); }
.product-overlay {
    position: absolute; inset: 0;
    background: rgba(99,102,241,0.85);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.3s;
}
.product-card:hover .product-overlay { opacity: 1; }
.product-badge {
    position: absolute; top: 12px; left: 12px;
    background: linear-gradient(135deg, #ef4444, #f97316);
    color: #fff; font-size: 0.7rem; font-weight: 700;
    padding: 4px 10px; border-radius: 50px; text-transform: uppercase;
}
.product-body { padding: 18px; }
.product-category { font-size: 0.75rem; color: #6366f1; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
.product-name { font-weight: 700; color: #1e1b4b; margin: 4px 0 8px; font-size: 1rem; }
.product-price { font-size: 1.2rem; font-weight: 800; color: #6366f1; }
.btn-add-cart {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none; color: #fff; padding: 10px 20px;
    border-radius: 50px; font-weight: 600; font-size: 0.85rem;
    transition: all 0.3s; width: 100%;
}
.btn-add-cart:hover { transform: scale(1.03); box-shadow: 0 8px 20px rgba(99,102,241,0.4); color: #fff; }
.btn-add-cart:disabled { opacity: 0.5; cursor: not-allowed; }
.promo-banner {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
    border-radius: 28px; padding: 60px 50px; position: relative; overflow: hidden;
}
.promo-banner::before {
    content: ''; position: absolute; width: 300px; height: 300px;
    background: rgba(99,102,241,0.3); border-radius: 50%;
    top: -80px; right: -80px; animation: pulse-glow 4s infinite;
}
.promo-timer { display: flex; gap: 12px; }
.timer-box {
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
    border-radius: 12px; padding: 12px 16px; text-align: center; min-width: 65px; color: #fff;
}
.timer-num { font-size: 1.8rem; font-weight: 800; line-height: 1; }
.timer-label { font-size: 0.65rem; text-transform: uppercase; opacity: 0.7; letter-spacing: 1px; }
.feature-card {
    background: #fff; border-radius: 20px; padding: 32px 24px; text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.3s; border: 2px solid transparent;
}
.feature-card:hover { border-color: #6366f1; transform: translateY(-6px); box-shadow: 0 20px 50px rgba(99,102,241,0.12); }
.feature-icon { width: 72px; height: 72px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
@keyframes floatUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
.animate-on-scroll { opacity: 0; transform: translateY(30px); transition: all 0.6s cubic-bezier(0.4,0,0.2,1); }
.animate-on-scroll.visible { opacity: 1; transform: translateY(0); }
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero-section">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge">👉 አንኳን ወደ ተሸሾፕ በደህና መጡ</div>
                <h1 class="hero-title mb-3">ፈጣን፣ ቀላል እና<br><span>የታመነ ግዢ</span></h1>
                <p class="hero-subtitle mb-5">የonline ግዢ መድረክ — ጥራት ያለው ምርት በቀላሉ ይግዙ!</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products') }}" class="btn hero-btn-primary"><i class="fas fa-shopping-bag me-2"></i>አሁን ይግዙ</a>
                    <a href="#featured" class="btn hero-btn-outline"><i class="fas fa-star me-2"></i>ምርጥ ምርቶች</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-wrap">
                    <!-- Local hero image — no text overlay -->
                    <div style="position:relative;display:inline-block;width:100%;">
                        <img src="{{ asset('images/hero.jpg') }}" class="img-fluid" alt="ተሸሾፕ"
                             style="border-radius:24px;box-shadow:0 30px 80px rgba(0,0,0,0.5);width:100%;object-fit:cover;">
                        <!-- Payment logos bottom strip inside image -->
                        <div style="position:absolute;bottom:0;left:0;right:0;border-radius:0 0 24px 24px;background:linear-gradient(to top, rgba(0,0,0,0.72) 0%, transparent 100%);padding:18px 20px 14px;display:flex;align-items:center;gap:12px;">
                            <span style="color:rgba(255,255,255,0.7);font-size:0.72rem;font-weight:600;white-space:nowrap;">Pay with</span>
                            <!-- Telebirr logo -->
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Telebirr_Logo.png/320px-Telebirr_Logo.png"
                                 alt="Telebirr" style="height:28px;object-fit:contain;filter:brightness(0) invert(1);opacity:0.9;"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            <span style="display:none;background:#00897b;color:#fff;font-size:0.7rem;padding:4px 10px;border-radius:20px;font-weight:700;">Telebirr</span>
                            <!-- CBE Birr -->
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Commercial_Bank_of_Ethiopia_Logo.svg/320px-Commercial_Bank_of_Ethiopia_Logo.svg.png"
                                 alt="CBE" style="height:28px;object-fit:contain;filter:brightness(0) invert(1);opacity:0.9;"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            <span style="display:none;background:#1565c0;color:#fff;font-size:0.7rem;padding:4px 10px;border-radius:20px;font-weight:700;">CBEBirr</span>
                            <!-- Bank divider + icon -->
                            <div style="width:1px;height:24px;background:rgba(255,255,255,0.3);"></div>
                            <div style="display:flex;align-items:center;gap:6px;color:#fff;font-size:0.75rem;font-weight:600;">
                                <i class="fas fa-university" style="font-size:1rem;opacity:0.85;"></i>
                                Bank Transfer
                            </div>
                        </div>
                    </div>
                    <!-- Rating float card -->
                    <div class="hero-float-card card-2">
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-size:1.4rem;">⭐</span>
                            <div><div style="font-weight:700;">4.9 Rating</div><div style="opacity:0.7;font-size:0.75rem;">10,000+ happy customers</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="stats-bar">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-number" data-count="{{ \App\Models\Product::count() }}">0</div><div class="stat-label">ምርቶች</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-number" data-count="{{ \App\Models\User::count() }}">0</div><div class="stat-label">ደንበኞች</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-number" data-count="{{ \App\Models\Order::count() }}">0</div><div class="stat-label">ትዕዛዞች</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-number" data-count="{{ \App\Models\Brand::count() }}">0</div><div class="stat-label">ብራንዶች</div></div></div>
        </div>
    </div>
</div>

<!-- CATEGORIES -->
<section class="py-5" style="background:#f8f7ff;">
    <div class="container">
        <div class="text-center mb-5 animate-on-scroll">
            <div class="section-label">ይቃልኩ</div>
            <h2 class="section-heading">በምድብ ይግዙ</h2>
            <p class="text-muted">ትፈልጉትን በትክክል ያግኙ</p>
        </div>
        <div class="row g-4">
            @foreach($categories as $i => $category)
            <div class="col-lg-3 col-md-4 col-6 animate-on-scroll" style="transition-delay:{{ $i * 80 }}ms">
                <a href="{{ route('products', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="category-card">
                        <div class="category-icon">
                            @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" style="width:40px;height:40px;object-fit:cover;border-radius:50%;" alt="{{ $category->name }}">
                            @else
                                <i class="fas fa-tag fa-lg" style="color:#6366f1;"></i>
                            @endif
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                        <span class="category-browse">ይመልከቱ →</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- PROMO BANNER -->
<section class="py-5" style="background:#fff;">
    <div class="container animate-on-scroll">
        <div class="promo-banner">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <div class="hero-badge mb-3">⚡ ለተወሰነ ጊዜ ብቻ</div>
                    <h2 style="color:#fff;font-size:2.2rem;font-weight:800;">እስከ 50% ቅናሽ<br>በተመረጡ ምርቶች ላይ</h2>
                    <p style="color:rgba(255,255,255,0.7);" class="mb-4">የዚህን ወቅት ትልቁን ቅናሽ አያምልጥዎ። አሁኑኑ ይግዙ — ከማለቁ በፊት!</p>
                    <a href="{{ route('products') }}" class="btn hero-btn-primary">ቅናሹን ይጠቀሙ</a>
                </div>
                <div class="col-lg-5">
                    <p style="color:rgba(255,255,255,0.7);font-size:0.85rem;text-transform:uppercase;letter-spacing:1px;" class="mb-2">ቅናሹ የሚያልቀው:</p>
                    <div class="promo-timer">
                        <div class="timer-box"><div class="timer-num" id="t-hours">00</div><div class="timer-label">ሰዓት</div></div>
                        <div class="timer-box"><div class="timer-num" id="t-mins">00</div><div class="timer-label">ደቂቃ</div></div>
                        <div class="timer-box"><div class="timer-num" id="t-secs">00</div><div class="timer-label">ሰከንድ</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="py-5" id="featured" style="background:#f8f7ff;">
    <div class="container">
        <div class="text-center mb-5 animate-on-scroll">
            <div class="section-label">የተመረጡ</div>
            <h2 class="section-heading">ምርጥ ምርቶች</h2>
            <p class="text-muted">ለእርስዎ የተመረጡ ምርጡ ምርቶች</p>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $i => $product)
            <div class="col-lg-3 col-md-6 animate-on-scroll" style="transition-delay:{{ $i * 100 }}ms">
                <div class="product-card h-100">
                    @if($product->on_sale)<div class="product-badge">ቅናሽ</div>@endif
                    <div class="product-img-wrap">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ $product->first_image }}" alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light"><i class="fas fa-image fa-3x text-muted"></i></div>
                        @endif
                        <div class="product-overlay">
                            <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-light btn-sm rounded-pill px-4"><i class="fas fa-eye me-1"></i>በፍጥነት ይመልከቱ</a>
                        </div>
                    </div>
                    <div class="product-body">
                        <div class="product-category">{{ $product->category->name }} • {{ $product->brand->name }}</div>
                        <div class="product-name">{{ $product->name }}</div>
                        <p class="text-muted small mb-3">{{ Str::limit($product->description, 70) }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="product-price">Birr {{ number_format($product->price, 0, '.', ',') }}</span>
                            @if($product->in_stock)
                                <span class="badge" style="background:#dcfce7;color:#16a34a;font-size:0.7rem;">አለ</span>
                            @else
                                <span class="badge" style="background:#fee2e2;color:#dc2626;font-size:0.7rem;">የለም</span>
                            @endif
                        </div>
                        <button onclick="addToCart({{ $product->id }})" class="btn btn-add-cart" {{ !$product->in_stock ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus me-2"></i>ወደ ጋሪ ይጨምሩ
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5 animate-on-scroll">
            <a href="{{ route('products') }}" class="btn hero-btn-primary btn-lg px-5">ሁሉንም ምርቶች ይመልከቱ <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="py-5" style="background:#fff;">
    <div class="container">
        <div class="text-center mb-5 animate-on-scroll">
            <div class="section-label">የእኝ ቃል</div>
            <h2 class="section-heading">ለምን እኛን ይምረጡ</h2>
        </div>
        <div class="row g-4">
            @php
            $features = [
                ['icon'=>'fas fa-shipping-fast','color'=>'#eef2ff','icolor'=>'#6366f1','title'=>'ፈጣን ማድረስ','desc'=>'በኢትዮጵያ ውስጥ ወደ መገኛዎ ቤት ፈጣን እና የተመራጭ አበርካታ.'],
                ['icon'=>'fas fa-shield-alt','color'=>'#f0fdf4','icolor'=>'#16a34a','title'=>'ደህንነቱ የተጠበቀ ክፍያ','desc'=>'ክፍያዎ በባንክ ደረጃ ምስጠራ እና ደህንነት የተጠበቀ ነው.'],
                ['icon'=>'fas fa-undo','color'=>'#fff7ed','icolor'=>'#ea580c','title'=>'ቀላል መመለስ','desc'=>'ያስደስትዎት ከሌለ? በ7 ቀን ውስጥ ሳይጠየቁ ይመለሱ.'],
                ['icon'=>'fas fa-headset','color'=>'#fdf4ff','icolor'=>'#9333ea','title'=>'24/7 ድጋፍ','desc'=>'የድጋፍ ቡዳችን በማንኛውም ጊዜ እርስዎ ለመርዳት ዝግጁ ነው.'],
            ];
            @endphp
            @foreach($features as $i => $f)
            <div class="col-md-6 col-lg-3 animate-on-scroll" style="transition-delay:{{ $i * 100 }}ms">
                <div class="feature-card">
                    <div class="feature-icon" style="background:{{ $f['color'] }};"><i class="{{ $f['icon'] }}" style="color:{{ $f['icolor'] }};font-size:1.5rem;"></i></div>
                    <h6 style="font-weight:700;color:#1e1b4b;margin-bottom:8px;">{{ $f['title'] }}</h6>
                    <p class="text-muted small mb-0">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count);
    let count = 0;
    const step = Math.max(1, Math.ceil(target / 60));
    const timer = setInterval(() => {
        count = Math.min(count + step, target);
        el.textContent = count.toLocaleString();
        if (count >= target) clearInterval(timer);
    }, 30);
});

function startTimer() {
    const end = new Date();
    end.setHours(end.getHours() + 24);
    setInterval(() => {
        const diff = end - new Date();
        if (diff <= 0) return;
        document.getElementById('t-hours').textContent = String(Math.floor(diff / 3600000)).padStart(2,'0');
        document.getElementById('t-mins').textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2,'0');
        document.getElementById('t-secs').textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2,'0');
    }, 1000);
}
startTimer();
</script>
@endpush
