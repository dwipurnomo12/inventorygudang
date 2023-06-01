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



