<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryStatus extends Model
{
    protected $table = 'history_statuses';
    protected $id = 'id';
    protected $guarded = ['id'];
    // protected $keyType = 'string';
    // public $incrementing = false;
    use HasFactory;
    use SoftDeletes;
}
