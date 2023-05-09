<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMutasi extends Model
{
    use HasFactory;
    protected $table = 'detail_mutasi';
    protected $guarded = [];

    protected $primaryKey = 'kd_det_mutasi';
}
