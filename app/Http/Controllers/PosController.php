<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\PosBusiness;

class PosController extends Controller
{
    protected $business;

    public function __construct(PosBusiness $business)
    {
        $this->business = $business;
    }

    public function loginPage()
    {
        return view('pos.login');
    }

    public function login(Request $request)
    {
        $user = $this->business->login(
            $request->username,
            $request->password
        );

        if (!$user) {
            return back()->with('error', 'Kullanıcı adı veya şifre hatalı!');
        }

        session([
            'user' => (array)$user
        ]);

        return redirect()->route('pos.index');
    }

    public function logout()
    {
        session()->flush();

        return redirect()->route('pos.loginPage');
    }

    public function index()
    {
        $products = $this->business->getProducts();
        $categories = $this->business->getCategories();

        $cart = session()->get('cart', []);

        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['SatirToplam'];
        }

        $tax = $subtotal * 0.10;
        $total = $subtotal + $tax;

        return view('pos.index', compact(
            'products',
            'categories',
            'cart',
            'subtotal',
            'tax',
            'total'
        ));
    }

    public function addItem(Request $request)
    {
        $cart = session()->get('cart', []);

        $found = false;

        foreach ($cart as $index => $item) {

            if ($item['UrunID'] == $request->urun_id) {

                $cart[$index]['Adet'] += 1;

                $cart[$index]['SatirToplam'] =
                    $cart[$index]['Adet'] * $cart[$index]['BirimFiyat'];

                $found = true;
                break;
            }
        }

        if (!$found) {

            $cart[] = [
                'UrunID' => $request->urun_id,
                'UrunAdi' => $request->urun_adi,
                'Adet' => 1,
                'BirimFiyat' => $request->birim_fiyat,
                'SatirToplam' => $request->birim_fiyat
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('pos.index');
    }

    public function clearCart()
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
            ->with('error', 'Cart is empty!');
    }

    $subtotal = 0;

    foreach ($cart as $item) {
        $subtotal += $item['SatirToplam'];
    }

    $discountPercent = $request->discount ?? 0;
    $discountAmount = $subtotal * ($discountPercent / 100);

    $user = session('user');

    $personelID = is_array($user)
        ? ($user['PersonelID'] ?? 2)
        : ($user->PersonelID ?? 2);

    $saleID = $this->business->createOrder(
        $cart,
        $request->payment_method ?? 'Nakit',
        $request->sale_type ?? 'Salon',
        $request->table_no ?? null,
        $discountAmount,
        $personelID
    );

    session()->forget('cart');
    session()->forget('selected_table');

    session()->flash('receipt_id', $saleID);

    return redirect()->route('pos.index');
}

    public function receipt($id)
{
    $receipt = $this->business->getSaleReceipt($id);

    return view('pos.receipt', compact('receipt'));
}

    public function reports()
    {
        $daily = $this->business->getDailyReport();

        $bestSelling = $this->business->getBestSellingProducts();

        $recentTransactions =
            $this->business->getRecentTransactions();

        return view(
            'pos.reports',
            compact(
                'daily',
                'bestSelling',
                'recentTransactions'
            )
        );
    }

    public function manageProducts()
    {
        $products = $this->business->getProducts();

        $categories = $this->business->getCategories();

        return view(
            'pos.manage-products',
            compact('products', 'categories')
        );
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
            ->with('success', 'Product added!');
    }

    public function deleteProduct($id)
    {
        $this->business->deleteProduct($id);

        return redirect()
            ->route('pos.manageProducts')
            ->with('success', 'Product deleted!');
    }

    public function manageStaff()
    {
        $staff = $this->business->getStaff();

        return view(
            'pos.manage-staff',
            compact('staff')
        );
    }

    public function toggleStaff($id)
    {
        $this->business->toggleStaff($id);

        return redirect()
            ->route('pos.manageStaff')
            ->with('success', 'Staff status updated!');
    }

    public function tables()
{
    $tables = range(1, 12);

    return view('pos.tables', compact('tables'));
}

    public function selectTable($id)
    {
        session([
            'selected_table' => $id
        ]);

        return redirect()->route('pos.index');
    }
    public function editStaff($id)
    {
        $person = $this->business->getStaffById($id);
    
        return view('pos.edit-staff', compact('person'));
    }
    
    public function updateStaff(Request $request, $id)
    {
        $this->business->updateStaff(
            $id,
            $request->ad,
            $request->soyad,
            $request->telefon,
            $request->gorev,
            $request->aktif_mi,
            $request->kullanici_adi,
            $request->sifre
        );
    
        return redirect()
            ->route('pos.manageStaff')
            ->with('success', 'Staff updated!');
    }
}