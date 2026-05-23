<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\PosBusiness;

class PosController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->business = new PosBusiness();
    }

    public function index()
    {
        if (!session()->has('user')) {
            return redirect()->route('pos.loginPage');
        }
    
        $products = $this->business->getProducts();
        $sales = $this->business->getSales();
    
        return view('pos.index', compact('products', 'sales'));
    }

    public function addItem(Request $request)
    {
        $cart = session()->get('cart', []);

        $cart[] = [
            'UrunID' => $request->urun_id,
            'UrunAdi' => $request->urun_adi,
            'Adet' => $request->adet,
            'BirimFiyat' => $request->birim_fiyat,
            'SatirToplam' => $request->adet * $request->birim_fiyat
        ];

        session()->put('cart', $cart);

        return redirect()->route('pos.index');
    }

    public function clearOrder()
    {
        session()->forget('cart');

        return redirect()->route('pos.index');
    }

    public function createOrder(Request $request)
{
    $cart = session()->get('cart', []);

    if (count($cart) == 0) {
        return redirect()
            ->route('pos.index')
            ->with('error', 'Sepet boş!');
    }

    $saleID = $this->business->createOrder(
        $cart,
        $request->payment_method ?? 'Nakit',
        $request->sale_type ?? 'Salon',
        $request->table_no ?? 1,
        $request->discount ?? 0,
        2
    );

    session()->forget('cart');

    session()->flash('receipt_id', $saleID);

    return redirect()->route('pos.index');
}

    public function pay(Request $request)
    {
        return $this->createOrder($request);
    }
    public function reports()
    {
        $daily = $this->business->getDailyReport();
        $bestSelling = $this->business->getBestSellingProducts();
    
        return view('pos.reports', compact('daily', 'bestSelling'));
    }
    public function loginPage()
    {
        return view('pos.login');
    }
    public function tables()
{
    $sales = $this->business->getSales();

    return view('pos.tables', compact('sales'));
}

public function selectTable($number)
{
    session()->put('selected_table', $number);

    return redirect()->route('pos.index');
}
    public function login(Request $request)
    {
        $user = $this->business->login(
            $request->username,
            $request->password
        );
    
        if (count($user) > 0) {
            session()->put('user', $user[0]);
            return redirect()->route('pos.index');
        }
    
        return redirect()->route('pos.loginPage')
            ->with('error', 'Kullanıcı adı veya şifre hatalı!');
    }
    
    public function logout()
    {
        session()->forget('user');
        session()->forget('cart');
    
        return redirect()->route('pos.loginPage');
    }
    public function increaseItem($index)
    {
        $cart = session()->get('cart', []);
    
        if (isset($cart[$index])) {
            $cart[$index]['Adet'] += 1;
            $cart[$index]['SatirToplam'] = $cart[$index]['Adet'] * $cart[$index]['BirimFiyat'];
        }
    
        session()->put('cart', $cart);
    
        return redirect()->route('pos.index');
    }
    
    public function decreaseItem($index)
    {
        $cart = session()->get('cart', []);
    
        if (isset($cart[$index])) {
            $cart[$index]['Adet'] -= 1;
    
            if ($cart[$index]['Adet'] <= 0) {
                unset($cart[$index]);
                $cart = array_values($cart);
            } else {
                $cart[$index]['SatirToplam'] = $cart[$index]['Adet'] * $cart[$index]['BirimFiyat'];
            }
        }
    
        session()->put('cart', $cart);
    
        return redirect()->route('pos.index');
    }
    
    public function removeItem($index)
    {
        $cart = session()->get('cart', []);
    
        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart);
        }
    
        session()->put('cart', $cart);
    
        return redirect()->route('pos.index');
    }
    public function receipt($id)
    {
        $receipt = $this->business->getSaleReceipt($id);
    
        return view('pos.receipt', compact('receipt'));
    }
    public function manageStaff()
{
    $staff = $this->business->getStaff();

    return view('pos.manage-staff', compact('staff'));
}

public function addStaff(Request $request)
{
    $this->business->addStaff(
        $request->ad,
        $request->soyad,
        $request->telefon,
        $request->gorev
    );

    return redirect()
        ->route('pos.manageStaff')
        ->with('success', 'Personel eklendi!');
}

public function deleteStaff($id)
{
    $this->business->deleteStaff($id);

    return redirect()
        ->route('pos.manageStaff')
        ->with('success', 'Personel silindi!');
}
public function manageProducts()
{
    $products = $this->business->getProducts();
    $categories = $this->business->getCategories();

    return view('pos.manage-products', compact('products', 'categories'));
}

public function addProduct(Request $request)
{
    $this->business->addProduct(
        $request->urun_adi,
        $request->birim_fiyat,
        $request->kategori_id
    );

    return redirect()
        ->route('pos.manageProducts')
        ->with('success', 'Ürün eklendi!');
}

public function deleteProduct($id)
{
    $this->business->deleteProduct($id);

    return redirect()
        ->route('pos.manageProducts')
        ->with('success', 'Ürün silindi!');
}
    
}