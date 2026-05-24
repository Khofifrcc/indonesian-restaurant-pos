<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Warung POS</title>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial}
body{background:#f8f5f2;color:#2b1b16}
.app{display:grid;grid-template-columns:240px 1fr 380px;min-height:100vh}

.sidebar{background:white;padding:30px 20px;border-right:1px solid #eee;position:relative}
.logo{font-size:28px;font-weight:900;color:#9f1239;display:flex;gap:8px;align-items:center}
.sub{color:#666;margin:8px 0 35px}

.nav{display:flex;flex-direction:column;gap:10px;margin-top:30px}
.nav a{text-decoration:none;color:#2d1f1f;padding:14px 16px;border-radius:16px;font-weight:700;display:flex;align-items:center;gap:10px}
.nav a:hover{background:#f3e9df}
.nav a.active{background:#9f1239!important;color:white!important;box-shadow:0 8px 18px rgba(159,18,57,.25)}
.nav a i{font-size:20px}

.logout{position:absolute;bottom:30px;left:20px;right:20px}
.clear{background:#f3e9df;border:none;border-radius:16px;padding:14px;width:100%;font-weight:bold;cursor:pointer}
.clear:hover{background:#9f1239;color:white}

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

.alert{padding:14px;border-radius:14px;margin-bottom:18px}
.success{background:#dcfce7;color:#166534}
.error{background:#fee2e2;color:#991b1b}

.receipt-modal{position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9999}
.receipt-box{width:460px;max-height:90vh;background:white;padding:20px;border-radius:24px}

@media(max-width:1100px){
    .app{grid-template-columns:1fr}
    .sidebar,.order{position:static}
    .grid{grid-template-columns:repeat(2,1fr)}
}
.type-btn{
    flex:1;
    background:white;
    border:1px solid #eee;
    border-radius:18px;
    padding:18px;
    cursor:pointer;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:8px;
    transition:.2s;
    font-weight:800;
}

.type-btn i{
    font-size:28px;
    color:#9f1239;
}

.type-btn.active{
    background:#9f1239;
    color:white;
    box-shadow:0 10px 20px rgba(159,18,57,.25);
}

.type-btn.active i{
    color:white;
}
</style>
</head>

<body>

<div class="app">

<aside class="sidebar">
    <div class="logo">
        <i class="bx bxs-store"></i> Warung POS
    </div>

    <div class="sub">Premium Restaurant System</div>

    @php
        $user = session('user');
    @endphp

    @if($user)
        <div style="background:#f3e9df;padding:14px;border-radius:16px;margin-bottom:22px;">
            <div style="font-weight:800;">
                <i class="bx bx-user"></i>
                {{ is_array($user) ? $user['Ad'] : $user->Ad }}
                {{ is_array($user) ? $user['Soyad'] : $user->Soyad }}
            </div>

            <div style="color:#666;font-size:14px;margin-top:6px;">
                {{ is_array($user) ? $user['Gorev'] : $user->Gorev }}
            </div>
        </div>
    @endif

    <div class="nav">
        

        <a href="{{ route('pos.tables') }}">
            <i class="bx bx-table"></i> Tables
        </a>
        <a class="active" href="{{ route('pos.index') }}">
            <i class="bx bx-cart"></i> POS Order
        </a>

        <a href="{{ route('pos.manageProducts') }}">
            <i class="bx bx-food-menu"></i> Products
        </a>

        <a href="{{ route('pos.manageStaff') }}">
            <i class="bx bx-group"></i> Staff
        </a>

        <a href="{{ route('pos.reports') }}">
            <i class="bx bx-bar-chart-alt-2"></i> Analytics
        </a>
    </div>

    <form class="logout" method="POST" action="{{ route('pos.logout') }}">
        @csrf
        <button class="clear">
            <i class="bx bx-log-out"></i> Logout
        </button>
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
            <div class="tab" onclick="filterMenu('{{ $cat }}', this)">
                {{ $cat }}
            </div>
        @endforeach
    </div>

    <div class="grid">
        @foreach($products as $product)
            @php
                $image='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500';
                $name=strtolower($product->UrunAdi);

                if(str_contains($name,'nasi')) $image='https://i.pinimg.com/1200x/d3/7b/f1/d37bf17c96e03b533f0f4b1c9b130011.jpg';
                if(str_contains($name,'mie')) $image='https://i.pinimg.com/736x/46/6d/d3/466dd3d62f2d7a1b6266ba6fa63f97ac.jpg';
                if(str_contains($name,'satay') || str_contains($name,'sate')) $image='https://i.pinimg.com/1200x/6f/7f/8e/6f7f8ee05147aae0a422aae3bd8cc1d3.jpg';
                if(str_contains($name,'soto')) $image='https://i.pinimg.com/736x/d9/14/ee/d914eedf08d2a7c9e1463b155fd471b0.jpg';
                if(str_contains($name,'pisang')) $image='https://i.pinimg.com/1200x/8c/70/52/8c705214211a3f84a6abc76e0daa4a7d.jpg';
                if(str_contains($name,'teh')) $image='https://i.pinimg.com/736x/1b/9a/23/1b9a2382bc0fb55a1f8cea2c28e1be12.jpg';
                if(str_contains($name,'kwetiau')) $image='https://i.pinimg.com/1200x/61/e0/b1/61e0b18c6f9a45f837861e56facaa236.jpg';
                if(str_contains($name,'bakso')) $image='https://i.pinimg.com/1200x/46/4c/83/464c833bb65da1a7b9611fe14799a69c.jpg';
                if(str_contains($name,'nasi padang')) $image='https://i.pinimg.com/736x/a1/06/8d/a1068df230801031fd0b9df8b4c92e6c.jpg';
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
                    <button type="submit" class="delete-btn">
                        <i class="bx bx-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @endforeach

    @php
        $discountPreview = 0;
        $total = $subtotal;
    @endphp

    <div class="total-box">
        <div class="row">
            <span>Subtotal</span>
            <strong>₺ {{ number_format($subtotal,2) }}</strong>
        </div>

        <div class="row">
            <span>Discount</span>
            <strong id="discountPreview">- ₺ 0.00</strong>
        </div>

        <div class="row total">
            <span>Total</span>
            <span id="grandTotal">₺ {{ number_format($total,2) }}</span>
        </div>
    </div>

    <form id="paymentForm" method="POST" action="{{ route('pos.createOrder') }}">
    @csrf

    <label>Order Type</label>

<input type="hidden"
       name="sale_type"
       id="saleTypeInput"
       value="Salon">

<div class="type-wrapper" style="display:flex;gap:12px;margin:15px 0 20px;">
    
    <button type="button"
            class="type-btn active"
            data-value="Salon"
            onclick="selectType(this)">

        <i class='bx bx-store'></i>
        <span>Salon</span>

    </button>

    <button type="button"
            class="type-btn"
            data-value="Paket"
            onclick="selectType(this)">

        <i class='bx bx-package'></i>
        <span>Paket</span>

    </button>

</div>

    <div id="tableArea">
        <label>Table Number</label>

        <input type="number"
               name="table_no"
               id="tableInput"
               value="{{ session('selected_table', 1) }}">
    </div>

    <label>Payment Method</label>

    <select name="payment_method" required>
        <option value="Nakit">Nakit</option>
        <option value="Kart">Kart</option>
    </select>

    <label>Discount (%)</label>

    <input type="number"
           name="discount"
           id="discountInput"
           value="0"
           min="0"
           max="100">

    <button class="btn pay"
            type="button"
            onclick="openPaymentModal()">

        <i class="bx bx-credit-card"></i>
        Proceed to Payment

    </button>
</form>
    <form method="POST" action="{{ route('pos.clear') }}">
        @csrf
        <button class="btn clear" type="submit">Clear Order</button>
    </form>
</aside>

</div>

<div id="paymentModal" class="receipt-modal" style="display:none;">
    <div class="receipt-box">
        <h2>Confirm Payment</h2>

        <p style="margin:15px 0;color:#666;">
            Are you sure you want to complete this order?
        </p>

        <div style="display:flex;gap:10px;">
            <button type="button" class="btn pay" onclick="document.getElementById('paymentForm').submit()">
                Confirm Payment
            </button>

            <button type="button" class="btn clear" onclick="closePaymentModal()">
                Cancel
            </button>
        </div>
    </div>
</div>

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
            <button onclick="window.open('{{ route('pos.receipt', session('receipt_id')) }}','_blank')" class="btn pay">
                Print
            </button>

            <button onclick="document.getElementById('receiptModal').style.display='none'" class="btn clear">
                Close
            </button>
        </div>
    </div>
</div>
@endif

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

const subtotal = {{ $subtotal }};

document.getElementById('discountInput')?.addEventListener('input', function(){
    let discountPercent = parseFloat(this.value) || 0;

    if(discountPercent > 100){
        discountPercent = 100;
        this.value = 100;
    }

    let discountAmount = subtotal * (discountPercent / 100);
    let total = subtotal - discountAmount;

    if(total < 0) total = 0;

    document.getElementById('discountPreview').innerText =
        '- ₺ ' + discountAmount.toFixed(2);

    document.getElementById('grandTotal').innerText =
        '₺ ' + total.toFixed(2);
});

function openPaymentModal(){
    document.getElementById('paymentModal').style.display = 'flex';
}

function closePaymentModal(){
    document.getElementById('paymentModal').style.display = 'none';
}


function selectType(el){
    document.querySelectorAll('.type-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    el.classList.add('active');

    const value = el.getAttribute('data-value');

    sessionStorage.setItem('sale_type', value);

    const saleTypeInput = document.getElementById('saleTypeInput');
    saleTypeInput.value = value;

    const tableArea = document.getElementById('tableArea');
    const tableInput = document.getElementById('tableInput');

    if(value === 'Paket'){
        tableArea.style.display = 'none';
        tableInput.value = '';
    }else{
        tableArea.style.display = 'block';

        if(!tableInput.value){
            tableInput.value = 1;
        }
    }
}

document.addEventListener('DOMContentLoaded', function(){
    const savedType = sessionStorage.getItem('sale_type') || 'Salon';
    const target = document.querySelector('.type-btn[data-value="' + savedType + '"]');

    if(target){
        selectType(target);
    }
});
</script>

</body>
</html>