<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebutuhan extends Model
{
    use HasFactory;
    protected $table = 'kebutuhan';
    protected $guarded = [];

    protected $primaryKey = 'kd_kebutuhan';
    public $incrementing = false;
}
