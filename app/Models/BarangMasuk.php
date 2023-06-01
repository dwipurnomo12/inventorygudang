<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BarangMasuk extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['kode_transaksi', 'tanggal_masuk', 'nama_barang', 'jumlah_masuk', 'supplier_id', 'user_id'];
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


    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

}
