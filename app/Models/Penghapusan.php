<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghapusan extends Model
{
    use HasFactory;
    protected $table = 'penghapusan';
    protected $guarded = [];

    protected $primaryKey = 'kd_penghapusan';
}
