<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BarangKeluar extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['kode_transaksi', 'tanggal_keluar', 'nama_barang', 'jumlah_keluar', 'customer_id', 'user_id'];
    protected $guarded = [''];
    protected $ignoreChangedAttributes = ['updated_at'];

    public function getActivitylogAttributes(): array
    {
        return array_diff($this->fillable, $this->ignoreChangedAttributes);
    }    

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    // 1 barang keluar hanya memiliki satu customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
