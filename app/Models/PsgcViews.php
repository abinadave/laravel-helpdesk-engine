<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsgcViews extends Model
{
    use HasFactory;
    protected $table = 'psgc_views';
    protected $primaryKey = 'id';
}
