@extends('layouts.app')
@section('title', 'ደረሰኝ ቅድመ እይታ')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 style="font-weight:800;color:#1e1b4b;">ደረሰኝ ቅድመ እይታ</h2>
                <div class="btn-group">
                    <a href="{{ route('invoice.download', $order) }}" class="btn btn-primary-custom">
                        <i class="fas fa-download me-2"></i>PDF አውርዱ
                    </a>
                    <a href="{{ route('invoice.view', $order) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>PDF ክፈቱ
                    </a>
                    <a href="{{ route('checkout.success', $order) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>ወደ ትዕዛዝ
                    </a>
                </div>
            </div>

            <div class="card-clean">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-md-6">
                            <h3 class="text-primary fw-bold">የኛ ገበያ</h3>
                            <p class="mb-1">ወሎ, ኢትዮጵያ</p>
                            <p class="mb-1">ስልክ: +251 962868748</p>
                            <p class="mb-0">ኢሜይል: tesheyimer86@gmail.com</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h4 class="fw-bold mb-3">ደረሰኝ</h4>
                            <p class="mb-1"><strong>ደረሰኝ ቁጥር:</strong> #{{ $order->id }}</p>
                            <p class="mb-1"><strong>ቀን:</strong> {{ $order->created_at->format('d M Y') }}</p>
                            <p class="mb-0"><strong>የክፍያ ቀነ ገደብ:</strong> {{ $order->created_at->addDays(30)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Order Status -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="bg-light p-3 rounded">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>የትዕዛዝ ሁኔታ:</strong>
                                        @php $sMap=['new'=>['አዲስ','primary'],'processing'=>['በሂደት','warning'],'shipped'=>['ተላከ','info'],'delivered'=>['ደረሰ','success'],'canceled'=>['ተሰረዘ','danger']]; $s=$sMap[$order->status]??['ያልታወቀ','secondary']; @endphp
                                        <span class="badge bg-{{ $s[1] }} ms-2">{{ $s[0] }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>የክፍያ ሁኔታ:</strong>
                                        @php $pMap=['paid'=>['ተከፍሏል','success'],'pending'=>['በመጠባበቅ','warning'],'failed'=>['አልተሳካም','danger']]; $p=$pMap[$order->payment_status]??['ያልታወቀ','secondary']; @endphp
                                        <span class="badge bg-{{ $p[1] }} ms-2">{{ $p[0] }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>የክፍያ ዘዴ:</strong>
                                        {{ $order->payment_method ?? 'አልተገለጸም' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing & Shipping -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">ለ:</h6>
                            <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                            <p class="mb-0">{{ $order->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">የመላኪያ አድራሻ:</h6>
                            @if($order->address)
                                <p class="mb-1"><strong>{{ $order->address->first_name }} {{ $order->address->last_name }}</strong></p>
                                <p class="mb-1">{{ $order->address->street_address }}</p>
                                <p class="mb-1">{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}</p>
                                <p class="mb-1">{{ $order->address->country }}</p>
                                <p class="mb-0">ስልክ: {{ $order->address->phone }}</p>
                            @else
                                <p class="text-muted">የመላኪያ አድራሻ አልተሰጠም</p>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width:50%">ምርት</th>
                                    <th style="width:15%" class="text-center">ብዛት</th>
                                    <th style="width:20%" class="text-end">የአንድ ዋጋ</th>
                                    <th style="width:15%" class="text-end">ጠቅላላ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product->name }}</strong>
                                        @if($item->product->category)
                                            <br><small class="text-muted">ምድብ: {{ $item->product->category->name }}</small>
                                        @endif
                                        @if($item->product->brand)
                                            <br><small class="text-muted">ብራንድ: {{ $item->product->brand->name }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Birr {{ number_format($item->unit_amount, 2, '.', ',') }}</td>
                                    <td class="text-end">Birr {{ number_format($item->total_amount, 2, '.', ',') }}</td>
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
                                <tr><td><strong>ድምር:</strong></td><td class="text-end">Birr {{ number_format($order->items->sum('total_amount'), 2, '.', ',') }}</td></tr>
                                @if($order->shipping_amount)
                                <tr><td><strong>የመላኪያ ዋጋ:</strong></td><td class="text-end">Birr {{ number_format($order->shipping_amount, 2, '.', ',') }}</td></tr>
                                @endif
                                <tr class="table-primary">
                                    <td><strong>ጠቅላላ:</strong></td>
                                    <td class="text-end"><strong>Birr {{ number_format($order->grand_total, 2, '.', ',') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-5 pt-4 border-top">
                        <p class="fw-bold">ለግዢዎ እናመሰግናለን!</p>
                        <p class="text-muted">ይህ በኮምፒዩተር የተፈጠረ ደረሰኝ ነው። ፊርማ አያስፈልግም።</p>
                        <p class="text-muted">ለማንኛውም ጥያቄ: tesheyimer86@gmail.com<br>
                        የኛ ገበያ — የታመነ የ online ግዢ መድረክ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .btn-group, .navbar, footer { display: none !important; }
    .container { max-width: 100% !important; padding: 0 !important; }
    .card-clean { border: none !important; box-shadow: none !important; }
}
</style>
@endpush
@endsection
