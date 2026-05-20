<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Warung POS</title>

<style>
    .receipt-modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:9999;
}

.receipt-box{
    width:460px;
    max-height:90vh;
    background:white;
    padding:20px;
    border-radius:24px;
}
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial}
body{background:#f8f5f2;color:#2b1b16}
.app{display:grid;grid-template-columns:240px 1fr 380px;min-height:100vh}
.sidebar{background:white;padding:30px 20px;border-right:1px solid #eee;position:relative}
.logo{font-size:28px;font-weight:900;color:#9f1239}
.sub{color:#666;margin:8px 0 35px}
.nav a{display:block;padding:15px;border-radius:16px;text-decoration:none;color:#2b1b16;font-weight:bold;margin-bottom:12px}
.nav .active{background:#9f1239;color:white}
.logout{position:absolute;bottom:30px;left:20px;right:20px}
.main{padding:30px;overflow:auto}
.search{width:100%;padding:16px;border-radius:18px;border:1px solid #eee;margin:25px 0;background:white}
.tabs{display:flex;gap:12px;margin-bottom:25px;flex-wrap:wrap}
.tab{padding:12px 18px;border-radius:14px;background:white;border:1px solid #eee;font-weight:bold;cursor:pointer}
.tab.active{background:#9f1239;color:white}
.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.card{background:white;border-radius:20px;border:1px solid #eee;padding:16px;cursor:pointer;transition:.2s}
.card:hover{transform:translateY(-4px);box-shadow:0 10px 20px rgba(0,0,0,.08)}
.card img{width:100%;height:130px;object-fit:cover;border-radius:16px;margin-bottom:14px}
.name{font-size:18px;font-weight:800;margin-bottom:8px}
.category{color:#666;margin-bottom:12px}
.bottom{display:flex;justify-content:space-between;align-items:center}
.price{color:#d69b00;font-size:18px;font-weight:900}
.badge{background:#dcfce7;color:#15803d;padding:7px 11px;border-radius:999px;font-size:12px;font-weight:bold}
.order{background:white;border-left:1px solid #eee;padding:25px;overflow:auto}
.types{display:flex;gap:8px;margin:18px 0}
.types button{border:0;padding:11px 16px;border-radius:14px;background:#f3e9df;font-weight:bold}
.types .active{background:#9f1239;color:white}
input,select{width:100%;padding:14px;border-radius:14px;border:1px solid #eee;margin:8px 0 18px}
.item{background:#f3e9df;padding:15px;border-radius:16px;margin-bottom:12px}
.item-top{display:flex;justify-content:space-between;margin-bottom:12px}
.qty{display:flex;align-items:center;gap:14px}
.qty-btn,.delete-btn{width:34px;height:34px;border-radius:50%;border:1px solid #ddd;background:white;font-weight:bold;cursor:pointer}
.delete-btn{background:#fee2e2;color:red;border-color:#fecaca}
.total-box{margin-top:20px;border-top:1px solid #eee;padding-top:18px}
.row{display:flex;justify-content:space-between;margin-bottom:12px}
.total{color:#9f1239;font-size:24px;font-weight:900}
.btn{width:100%;padding:15px;border-radius:16px;border:0;font-weight:bold;cursor:pointer;margin-top:12px}
.pay{background:#9f1239;color:white}
.clear{background:#f3e9df}
.alert{padding:14px;border-radius:14px;margin-bottom:18px}
.success{background:#dcfce7;color:#166534}
.error{background:#fee2e2;color:#991b1b}
@media(max-width:1100px){.app{grid-template-columns:1fr}.sidebar,.order{position:static}.grid{grid-template-columns:repeat(2,1fr)}}
</style>
</head>

<body>

<div class="app">

<aside class="sidebar">
    <div class="logo">🍴 Warung POS</div>
    <div class="sub">Premium Restaurant System</div>

    <div class="nav">
        <a class="active" href="{{ route('pos.index') }}">🛒 POS Order</a>
        <a href="{{ route('pos.manageProducts') }}">🍔 Products</a>
        <a href="{{ route('pos.manageStaff') }}">👨‍🍳 Staff</a>
        <a href="{{ route('pos.reports') }}">📊 Analytics</a>
    </div>

    <form class="logout" method="POST" action="{{ route('pos.logout') }}">
        @csrf
        <button class="btn clear">Logout</button>
    </form>
</aside>

<main class="main">
    <h1>POS Order System</h1>
    <p>Select items to add to order</p>

    @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif

    <input class="search" id="searchInput" placeholder="Search menu...">

    @php
        $categories = collect($products)->pluck('KategoriAdi')->unique();
    @endphp

    <div class="tabs">
        <div class="tab active" onclick="filterMenu('all', this)">All</div>
        @foreach($categories as $cat)
            <div class="tab" onclick="filterMenu('{{ $cat }}', this)">{{ $cat }}</div>
        @endforeach
    </div>

    <div class="grid" id="menuGrid">
        @foreach($products as $product)
            @php
                $image = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500';
                $name = strtolower($product->UrunAdi);
                if(str_contains($name,'nasi')) $image='https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=500';
                if(str_contains($name,'mie')) $image='https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=500';
                if(str_contains($name,'satay') || str_contains($name,'sate')) $image='https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?w=500';
                if(str_contains($name,'soto')) $image='https://images.unsplash.com/photo-1547592166-23ac45744acd?w=500';
                if(str_contains($name,'pisang')) $image='https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=500';
                if(str_contains($name,'teh')) $image='https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=500';
                if(str_contains($name,'kopi')) $image='https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=500';
            @endphp

            <form class="product-form"
                  data-name="{{ strtolower($product->UrunAdi) }}"
                  data-category="{{ $product->KategoriAdi }}"
                  method="POST"
                  action="{{ route('pos.addItem') }}">
                @csrf

                <input type="hidden" name="urun_id" value="{{ $product->UrunID }}">
                <input type="hidden" name="urun_adi" value="{{ $product->UrunAdi }}">
                <input type="hidden" name="birim_fiyat" value="{{ $product->BirimFiyat }}">
                <input type="hidden" name="adet" value="1">

                <div class="card" onclick="this.closest('form').submit()">
                    <img src="{{ $image }}">
                    <div class="name">{{ $product->UrunAdi }}</div>
                    <div class="category">{{ $product->KategoriAdi }}</div>
                    <div class="bottom">
                        <div class="price">₺ {{ number_format($product->BirimFiyat,2) }}</div>
                        <div class="badge">Available</div>
                    </div>
                </div>
            </form>
        @endforeach
    </div>
</main>

<aside class="order">
    <h2>Current Order</h2>

    <div class="types">
        <button class="active" type="button">Dine-In</button>
        <button type="button">Takeaway</button>
        <button type="button">Delivery</button>
    </div>

    @php
        $cart = session('cart', []);
        $subtotal = 0;
    @endphp

    @foreach($cart as $index => $item)
        @php $subtotal += $item['SatirToplam']; @endphp

        <div class="item">
            <div class="item-top">
                <strong>{{ $item['UrunAdi'] }}</strong>
                <span>₺ {{ number_format($item['SatirToplam'],2) }}</span>
            </div>

            <div class="qty">
                <form method="POST" action="{{ route('pos.decrease', $index) }}">
                    @csrf
                    <button type="submit" class="qty-btn">−</button>
                </form>

                <span>{{ $item['Adet'] }}</span>

                <form method="POST" action="{{ route('pos.increase', $index) }}">
                    @csrf
                    <button type="submit" class="qty-btn">+</button>
                </form>

                <form method="POST" action="{{ route('pos.removeItem', $index) }}">
                    @csrf
                    <button type="submit" class="delete-btn">🗑</button>
                </form>
            </div>
        </div>
    @endforeach

    @php
        $tax = $subtotal * 0.10;
        $total = $subtotal + $tax;
    @endphp

    <div class="total-box">
        <div class="row"><span>Subtotal</span><strong>₺ {{ number_format($subtotal,2) }}</strong></div>
        <div class="row"><span>Tax (10%)</span><strong>₺ {{ number_format($tax,2) }}</strong></div>
        <div class="row total"><span>Total</span><span>₺ {{ number_format($total,2) }}</span></div>
    </div>

    <form method="POST" action="{{ route('pos.createOrder') }}">
        @csrf
        <input type="hidden" name="sale_type" value="Salon">
        <input type="hidden" name="payment_method" value="Nakit">
        <input type="hidden" name="discount" value="0">

        <label>Table Number</label>
        <input type="number" name="table_no" value="1">

        <button class="btn pay" type="submit">💳 Proceed to Payment</button>
    </form>

    <form method="POST" action="{{ route('pos.clear') }}">
        @csrf
        <button class="btn clear" type="submit">Clear Order</button>
    </form>
</aside>

</div>

<script>
function filterMenu(category, el){
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');

    document.querySelectorAll('.product-form').forEach(card => {
        const cardCategory = card.dataset.category;
        card.style.display = (category === 'all' || cardCategory === category) ? 'block' : 'none';
    });
}

document.getElementById('searchInput').addEventListener('input', function(){
    const keyword = this.value.toLowerCase();

    document.querySelectorAll('.product-form').forEach(card => {
        const name = card.dataset.name;
        card.style.display = name.includes(keyword) ? 'block' : 'none';
    });
});
</script>
@if(session('receipt_id'))
<div id="receiptModal" class="receipt-modal">
    <div class="receipt-box">
        <iframe
            src="{{ route('pos.receipt', session('receipt_id')) }}"
            width="100%"
            height="620"
            style="border:0;border-radius:12px;">
        </iframe>

        <div style="display:flex;gap:10px;margin-top:15px;">
            <button
                onclick="window.open('{{ route('pos.receipt', session('receipt_id')) }}','_blank')"
                class="btn pay">
                Print
            </button>

            <button
                onclick="document.getElementById('receiptModal').style.display='none'"
                class="btn clear">
                Close
            </button>
        </div>
    </div>
</div>
@endif
</body>
</html>