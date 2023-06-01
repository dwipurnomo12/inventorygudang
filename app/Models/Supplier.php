<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Supplier extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['supplier', 'alamat', 'user_id'];
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

    // 1 Supplier memiliki banyak barangMasuk
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }
}
