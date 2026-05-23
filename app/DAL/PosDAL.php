<?php

namespace App\DAL;

use Illuminate\Support\Facades\DB;

class PosDAL
{
    public function getProducts()
    {
        return DB::select('CALL sp_urun_select()');
    }

    public function createSale($satisTipi, $masaNo, $indirim, $odemeYontemi, $personelID)
    {
        return DB::select(
            'CALL sp_satis_insert(?, ?, ?, ?, ?)',
            [$satisTipi, $masaNo, $indirim, $odemeYontemi, $personelID]
        );
    }

    public function addSaleDetail($satisID, $urunID, $adet)
    {
        return DB::statement(
            'CALL sp_satis_detay_insert(?, ?, ?)',
            [$satisID, $urunID, $adet]
        );
    }

    public function getSales()
    {
        return DB::select('CALL sp_satis_select()');
    }


    public function getDailyReport()
    {
        return DB::select('CALL sp_gunluk_satis_raporu()');
    }

    public function getBestSellingProducts()
    {
        return DB::select('CALL sp_en_cok_satilan_urunler()');
    }
    public function getCategories()
{
    return DB::select('CALL sp_kategori_select()');
}
public function getRecentTransactions()
{
    return DB::select('CALL sp_recent_transactions()');
}
public function addProduct($urunAdi, $birimFiyat, $kategoriID)
{
    return DB::statement(
        'CALL sp_urun_insert(?, ?, ?)',
        [$urunAdi, $birimFiyat, $kategoriID]
    );
}

public function deleteProduct($urunID)
{
    return DB::statement(
        'CALL sp_urun_delete(?)',
        [$urunID]
    );
}

public function getStaff()
{
    return DB::select('CALL sp_personel_select()');
}

public function addStaff($ad, $soyad, $telefon, $gorev)
{
    return DB::statement(
        'CALL sp_personel_insert(?, ?, ?, ?)',
        [$ad, $soyad, $telefon, $gorev]
    );
}

public function deleteStaff($personelID)
{
    return DB::statement(
        'CALL sp_personel_delete(?)',
        [$personelID]
    );
}
public function login($username, $password)
{
    return DB::table('PERSONEL')
        ->where('KullaniciAdi', $username)
        ->where('Sifre', $password)
        ->where('AktifMi', 'E')
        ->first();
}
public function getSaleReceipt($id)
{
    return DB::select(
        'CALL sp_fis_select(?)',
        [$id]
    );
}
}
