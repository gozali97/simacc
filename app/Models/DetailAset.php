<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAset extends Model
{
    use HasFactory;
    protected $table = 'detail_aset';
    protected $guarded = [];

    protected $primaryKey = 'kd_det_aset';
}
