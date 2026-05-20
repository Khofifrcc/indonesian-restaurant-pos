# Indonesian Restaurant POS System

## Proje Açıklaması | Deskripsi Proyek

Bu proje, Laravel ve MySQL kullanılarak geliştirilmiş modern bir restoran POS (Point Of Sale) sistemidir.  
Proje kapsamında Stored Procedure, Function, Trigger ve N-Layer Architecture kullanılmıştır.

Project ini adalah sistem POS (Point Of Sale) restoran modern yang dibuat menggunakan Laravel dan MySQL.  
Dalam project ini digunakan Stored Procedure, Function, Trigger, dan arsitektur N-Layer.

---

# Kullanılan Teknolojiler | Teknologi

- Laravel 13
- PHP 8
- MySQL
- HTML/CSS
- JavaScript
- Stored Procedure
- Function
- Trigger
- N-Layer Architecture

---

# Sistem Özellikleri | Fitur Sistem

## POS Order System
- Menü listeleme
- Sepete ürün ekleme
- Ürün adet artırma/azaltma
- Sipariş tamamlama
- Vergi hesaplama
- Ödeme sistemi

## Product Management
- Ürün ekleme
- Ürün silme
- Kategori bazlı ürün yönetimi

## Staff Management
- Personel ekleme
- Personel silme
- Görev yönetimi

## Analytics Dashboard
- Günlük satış raporu
- En çok satılan ürünler
- Toplam gelir
- Toplam sipariş

## Authentication
- Login sistemi
- Session kontrolü
- Logout sistemi

---

# Database Yapısı | Struktur Database

## Tablolar | Tabel
- KATEGORI
- URUN
- PERSONEL
- SATIS
- SATIS_DETAY

## Stored Procedure
- sp_urun_select
- sp_urun_insert
- sp_urun_delete
- sp_satis_insert
- sp_satis_detay_insert
- sp_personel_insert
- sp_personel_delete
- sp_login
- vb.

## Function
- fn_satis_toplam
- fn_personel_satis_sayisi

## Trigger
- trg_satis_detay_insert
- trg_satis_detay_after_insert

---

# Katmanlı Mimari | N-Layer Architecture

```text
UI Layer
↓
Controller Layer
↓
Business Layer
↓
DAL Layer
↓
Stored Procedure
↓
MySQL Database
