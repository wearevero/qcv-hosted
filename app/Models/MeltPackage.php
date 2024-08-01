<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Melt_statuse;
use App\Models\Melt_weight;

class MeltPackage extends Model
{
    protected $table = 'melt_packages';
    protected $id = 'barcode';
    protected $keyType = 'string';
    protected $guarded = ['id'];
    public $incrementing = false;

    use HasFactory;
    use SoftDeletes;

    // hasMany statuses
    public function statuses()
    {
        return $this->hasMany(Melt_statuse::class, 'barcode', 'barcode');
    }
    // hasMany weights
    public function weights()
    {
        return $this->hasMany(Melt_weight::class, 'barcode', 'barcode');
    }
}
