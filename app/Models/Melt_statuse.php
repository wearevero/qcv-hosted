<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MeltPackage;

class Melt_statuse extends Model
{
    protected $table = 'melt_statuses';
    protected $id = 'id';
    protected $guarded = ['id'];
    // protected $keyType = 'string';
    // public $incrementing = false;
    use HasFactory;
    use SoftDeletes;

    // belong to MeltPackage
    public function melt_package()
    {
        return $this->belongsTo(MeltPackage::class, 'barcode', 'barcode');
    }
}
