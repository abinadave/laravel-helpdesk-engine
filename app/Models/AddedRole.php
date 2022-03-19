<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddedRole extends Model
{
    use HasFactory;
    protected $table = 'added_roles';
    protected $primaryKey = 'id';
}
