<!DOCTYPE html>
<html>
<head>
<title>Receipt</title>

<style>
body{
    font-family:monospace;
    background:#eee;
    padding:10px;
}

.receipt{
    width:300px;
    background:white;
    margin:auto;
    padding:18px;
    border-radius:8px;
}

.center{text-align:center}

.row{
    display:flex;
    justify-content:space-between;
    margin:6px 0;
}

.total{
    font-size:18px;
}

hr{margin:12px 0}

button{
    width:100%;
    padding:12px;
    border:0;
    background:black;
    color:white;
    margin-top:15px;
    cursor:pointer;
}

@media print{
    body{
        background:white;
        padding:0;
        margin:0;
    }

    .receipt{
        width:58mm;
        padding:8mm 4mm;
        margin:0 auto;
        border-radius:0;
    }

    button{
        display:none;
    }

    @page{
        size:58mm auto;
        margin:0;
    }
}
</style>
</head>

<body>

@php
    $sale = $receipt[0] ?? null;

    $subtotal = 0;

    foreach($receipt as $item){
        $subtotal += $item->SatirToplam;
    }

    $discount = $sale->Indirim ?? 0;
    $grandTotal = $sale->ToplamTutar ?? ($subtotal - $discount);
@endphp

@if($sale)

<div class="receipt">

    <div class="center">
        <h2>WARUNG POS</h2>
        <p>Indonesian Restaurant</p>

        <hr>

        <p>Receipt No: {{ $sale->SatisID }}</p>
        <p>{{ $sale->SatisTarihiSaat }}</p>
        <p>Cashier: {{ $sale->Ad }} {{ $sale->Soyad }}</p>

        @if(isset($sale->MasaNo) && $sale->MasaNo)
            <p>Table: {{ $sale->MasaNo }}</p>
        @endif
    </div>

    <hr>

    @foreach($receipt as $item)
        <div>{{ $item->UrunAdi }}</div>

        <div class="row">
            <span>{{ $item->Adet }} x ₺ {{ number_format($item->BirimFiyat,2) }}</span>
            <span>₺ {{ number_format($item->SatirToplam,2) }}</span>
        </div>
    @endforeach

    <hr>

    <div class="row">
        <span>Subtotal</span>
        <span>₺ {{ number_format($subtotal,2) }}</span>
    </div>

    <div class="row">
        <span>Discount</span>
        <span>- ₺ {{ number_format($discount,2) }}</span>
    </div>

    <hr>

    <div class="row total">
        <strong>Total</strong>
        <strong>₺ {{ number_format($grandTotal,2) }}</strong>
    </div>

    <div class="row">
        <span>Payment</span>
        <span>{{ $sale->OdemeYontemi ?? '-' }}</span>
    </div>

    <button onclick="window.print()">Print Receipt</button>

    <hr>

    <div class="center">
        <p>Thank You ❤️</p>
        <p style="font-size:12px;color:#666;">Please Come Again</p>
    </div>

</div>

@endif

</body>
</html>