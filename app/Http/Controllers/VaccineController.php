<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaccine;
class VaccineController extends Controller
{
    public function getAllVaccineBrands(){
        return response()->json(Vaccine::all());
    }
}
