<!DOCTYPE html>
<html>
<head>
<title>Receipt</title>

<style>
body{
    font-family:monospace;
    background:#eee;
    padding:30px;
}

.receipt{
    width:340px;
    background:white;
    margin:auto;
    padding:25px;
    border-radius:8px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.center{
    text-align:center;
}

.row{
    display:flex;
    justify-content:space-between;
    margin:6px 0;
}

hr{
    margin:12px 0;
}

button{
    width:100%;
    padding:12px;
    border:0;
    background:black;
    color:white;
    margin-top:15px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="receipt">

    @php
        $first = $receipt[0];
        $total = 0;
    @endphp

    <div class="center">
        <h2>WARUNG POS</h2>

        <p>
            Indonesian Restaurant
        </p>

        <hr>

        <p>
            Receipt No:
            {{ $first->SatisID }}
        </p>

        <p>
            {{ $first->SatisTarihiSaat }}
        </p>

        <p>
            Cashier:
            {{ $first->Ad }}
            {{ $first->Soyad }}
        </p>
    </div>

    <hr>

    @foreach($receipt as $item)

        @php
            $total += $item->SatirToplam;
        @endphp

        <div>
            {{ $item->UrunAdi }}
        </div>

        <div class="row">
            <span>
                {{ $item->Adet }}
                x
                ₺ {{ number_format($item->BirimFiyat,2) }}
            </span>

            <span>
                ₺ {{ number_format($item->SatirToplam,2) }}
            </span>
        </div>

    @endforeach

    <hr>
    @php
    $tax = $total * 0.10;
    $grandTotal = $total + $tax;
@endphp

<div class="row">
    <span>Subtotal</span>
    <span>₺ {{ number_format($grandTotal,2) }}</span>
</div>

<div class="row">
    <span>Tax (10%)</span>
    <span>₺ {{ number_format($tax,2) }}</span>
</div>

<hr>
    <div class="row">
        <strong>Total</strong>

        <strong>
            ₺ {{ number_format($total,2) }}
        </strong>
    </div>

    <div class="row">
        <span>Payment</span>

        <span>
            {{ $first->OdemeYontemi }}
        </span>
    </div>

    <button onclick="window.print()">
        Print Receipt
    </button>

</div>
<hr>

<div class="center">
    <p>
        Thank You ❤️
    </p>

    <p style="font-size:12px;color:#666;">
        Please Come Again
    </p>
</div>

</body>
</html>