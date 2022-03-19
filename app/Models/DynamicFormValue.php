<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicFormValue extends Model
{
    use HasFactory;
    protected $table = 'dynamic_form_values';
    protected $primaryKey = 'id';
}
