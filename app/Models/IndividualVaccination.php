<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualVaccination extends Model
{
    use HasFactory;
    protected $table = 'individual_vaccinations';
    protected $primaryKey = 'id';
}
