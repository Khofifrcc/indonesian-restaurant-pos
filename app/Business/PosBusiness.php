<?php

namespace App\Business;

use App\DAL\PosDAL;

class PosBusiness
{
    protected $dal;

    public function __construct()
    {
        $this->dal = new PosDAL();
    }

    public function getProducts()
    {
        return $this->dal->getProducts();
    }

    public function createOrder($items, $paymentMethod, $saleType = 'Salon', $tableNo = null, $discount = 0, $personelID = 2)
    {
        $sale = $this->dal->createSale($saleType, $tableNo, $discount, $paymentMethod, $personelID);

        $saleID = $sale[0]->YeniSatisID;

        foreach ($items as $item) {
            $this->dal->addSaleDetail($saleID, $item['UrunID'], $item['Adet']);
        }

        return $saleID;
    }

    public function getSales()
    {
        return $this->dal->getSales();
    }


    public function getDailyReport()
    {
        return $this->dal->getDailyReport();
    }

    public function getBestSellingProducts()
    {
        return $this->dal->getBestSellingProducts();
    }
    public function getCategories()
{
    return $this->dal->getCategories();
}

public function addProduct($urunAdi, $birimFiyat, $kategoriID)
{
    return $this->dal->addProduct($urunAdi, $birimFiyat, $kategoriID);
}

public function deleteProduct($urunID)
{
    return $this->dal->deleteProduct($urunID);
}

public function getStaff()
{
    return $this->dal->getStaff();
}

public function addStaff($ad, $soyad, $telefon, $gorev)
{
    return $this->dal->addStaff($ad, $soyad, $telefon, $gorev);
}

public function deleteStaff($personelID)
{
    return $this->dal->deleteStaff($personelID);
}
public function getSaleReceipt($id)
{
    return $this->dal->getSaleReceipt($id);
}
public function toggleStaff($id)
{
    return $this->dal->toggleStaff($id);
}
public function login($username, $password)
{
    return $this->dal->login($username, $password);
}
}
