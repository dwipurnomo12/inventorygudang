<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Jenis;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name'      => 'Super Admin',
            'email'     => 'superadmin@gmail.com',
            'password'  => bcrypt('1234'),
            'role_id'   => 1
        ]);

        User::create([
            'name'      => 'Kepala Gudang',
            'email'     => 'kepalagudang@gmail.com',
            'password'  => bcrypt('1234'),
            'role_id'   => 2
        ]);

        User::create([
            'name'      => 'Admin Gudang',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('1234'),
            'role_id'   => 3
        ]);

        Jenis::create([
            'jenis_barang'  => 'pupuk cair',
            'user_id'       => 1
        ]);
        Jenis::create([
            'jenis_barang'  => 'pupuk Kimia',
            'user_id'       => 1
        ]);

        Satuan::create([
            'satuan'        => 'Kwintal',
            'user_id'       => 1
        ]);
        Satuan::create([
            'satuan'        => 'Liter',
            'user_id'       => 1
        ]);

        Supplier::create([
            'supplier'      => 'PT Petrokimia Gresik',
            'alamat'        => 'Gresik, Jawa Timur',
            'user_id'       => 1
        ]);
        Supplier::create([
            'supplier'      => 'PT Pupuk Indonesia',
            'alamat'        => 'Jakarta',
            'user_id'       => 1
        ]);

        Customer::create([
            'customer'      => 'CV Konco Tani',
            'alamat'        => 'Suronegaran, Jawa Tengah',
            'user_id'       => 1
        ]);
        Customer::create([
            'customer'      => 'CV Harapan Tani',
            'alamat'        => 'Baledono, Jawa Tengah',
            'user_id'       => 1
        ]);
        
        Role::create([
            'role'      => 'superadmin',
            'deskripsi' => 'Superadmin memiliki kendali penuh pada aplikasi termasuk manajemen User'
        ]);

        Role::create([
            'role'      => 'kepala gudang',
            'deskripsi' => 'Kepala gudang memilki akses untuk mengelola dan mencetak laporan stok, barang masuk, dan barang keluar'
        ]);

        Role::create([
            'role'      => 'admin gudang',
            'deskripsi' => 'Admin gudang memilki akses untuk mengelola stok,  barang masuk, barang keluar dan laporannya'
        ]);
     
    }
}
