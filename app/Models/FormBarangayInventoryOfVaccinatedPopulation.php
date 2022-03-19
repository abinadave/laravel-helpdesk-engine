<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormBarangayInventoryOfVaccinatedPopulation extends Model
{
    use HasFactory;
    protected $table = 'form_barangay_inventory_of_vaccinated_populations';
    protected $primaryKey = 'id';
}
