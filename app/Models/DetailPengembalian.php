<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengembalian extends Model
{
    use HasFactory;
    protected $table = 'detail_pengembalian';
    protected $guarded = [];

    protected $primaryKey = 'kd_det_pengembalian';
}
