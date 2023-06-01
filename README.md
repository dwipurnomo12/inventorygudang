<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Sistem Informasi Inventory Gudang


Sistem Informasi Inventory Gudang Berbasis Web adalah aplikasi atau sistem yang digunakan untuk mengelola inventaris atau stok barang di dalam gudang melalui platform web. Sistem ini dirancang untuk memudahkan proses pengelolaan, pemantauan, dan pengendalian persediaan barang secara efisien.


## Fitur
- Data Master
    1. Data Barang
    2. Jenis
    3. Satuan
    4. Perusahaan
        - Customer
        - Supplier
- Transaksi
    1. Barang Masuk
    2. Barang Keluar
- Laporan
    1. Laporan Stok (Print)
    2. Laporan Barang Masuk (Print)
    3. Laporan Barang Keluar (Print)
- Manajemen User
    1. Data Pengguna/User
    2. Hak Akses/Role
    3. Acitvity Log
- Ubah Password



## Teknologi

Sistem Informasi Inventory Gudang menggunakan beberapa Teknologi diantaranya :

- Laravel - The PHP Framework for Web Artisans
- JavaScript - JavaScript, often abbreviated as JS, is a programming language that is one of the core technologies of the World Wide Web, alongside HTML and CSS.
- jQuery - jQuery is a JavaScript framework designed to simplify HTML DOM tree traversal and manipulation, as well as event handling, CSS animation, and Ajax.
- Bootstrap - Bootstrap is a free and open-source CSS framework directed at responsive, mobile-first front-end web development. 


## Installasi

Lakukan Clone Project/Unduh manual 

Buat database dengan nama 'inventorygudang'

Jika melakukan Clone Project, rename file .env.example dengan env dan hubungkan
database nya dengan mengisikan nama database, 'DB_DATABASE=inventorygudang'


Kemudian, Ketik pada terminal :
```sh
php artisan migrate
```

Lalu ketik juga

```sh
php artisan migrate:fresh --seed
```

Jalankan aplikasi 

```sh
php artisan serve
```

Akses Aplikasi di Web browser 
```sh
127.0.0.1:8000
```



## Screenshoot
![Screenshot_924-min](https://github.com/dwipurnomo12/inventorygudang/assets/105181667/a1d872ba-c3fb-4fe8-8dcd-62032a56e240)

![Screenshot_925](https://github.com/dwipurnomo12/inventorygudang/assets/105181667/222bd666-0f6c-4814-b6c8-4b608164647d)

![Screenshot_926](https://github.com/dwipurnomo12/inventorygudang/assets/105181667/b7e9824b-c8b5-4078-8d7d-7b26ffaf5460)

![Screenshot_927](https://github.com/dwipurnomo12/inventorygudang/assets/105181667/a0d2ad61-b4a2-470b-b7d4-40679328b1b2)

![Screenshot_928](https://github.com/dwipurnomo12/inventorygudang/assets/105181667/d64360e9-8496-4f18-bee9-bf1f5223c792)



