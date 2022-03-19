<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormBarangayInventoryOfVaccinatedPopulation;
use Illuminate\Support\Facades\DB;

class FormBarangayController extends Controller
{

    public function fetchByLocation(Request $request){
        $current_psgc_user = $request->current_psgc_user;
        // FormBarangayInventoryOfVaccinatedPopulation
        $data = DB::table('form_barangay_views')->where('province', $current_psgc_user['provCode'])
                ->where('city_mun', $current_psgc_user['citymunCode'])
                ->where('brgy', $current_psgc_user['brgy'])
                ->get();
        return response()->json($data);
    }
    public function submitForm1(Request $request){
        #Validate Duplicate
        $form1 = new \stdClass();
        $current_psg_user = $request->current_psgc_user;
        $countDuplicate = FormBarangayInventoryOfVaccinatedPopulation::where('year', $request->year)
                ->where('month', $request->month)
                ->where('province', $current_psg_user['provCode'])
                ->where('city_mun', $current_psg_user['citymunCode'])
                ->where('brgy', $current_psg_user['brgy'])
                ->count();

        #Check if it has Duplicate before saving...
        if(!$countDuplicate){
            $form1 = new FormBarangayInventoryOfVaccinatedPopulation;
            $form1->total_no_of_population = $request->total_no_of_population;
            $form1->total_no_of_unvaccinated_individuals = $request->total_no_of_unvaccinated_individuals;
            $form1->percentage_of_unvaccinated_indivisuals = $request->percentage_of_unvaccinated_indivisuals;
            $form1->total_no_of_partially_vaccinated_individuals = $request->total_no_of_partially_vaccinated_individuals;
            $form1->percentage_of_partially_vaccinated_individuals = $request->percentage_of_partially_vaccinated_individuals;
            $form1->total_no_of_fully_vaccinated_individuals = $request->total_no_of_fully_vaccinated_individuals;
            $form1->percentage_of_fully_vaccinated_individuals = $request->percentage_of_fully_vaccinated_individuals;
            $form1->total_no_of_individuals_with_booster_shot = $request->total_no_of_individuals_with_booster_shot;
            $form1->percentage_of_individuals_with_booster_shot = $request->percentage_of_individuals_with_booster_shot;

            #Year and Month of Form Submission
            $form1->month = $request->month;
            $form1->year = $request->year;

            #Location of Data
            $form1->province = $current_psg_user['provCode'];
            $form1->city_mun = $current_psg_user['citymunCode'];
            $form1->brgy = $current_psg_user['brgy'];
            $form1->encoded_by_user_id = $current_psg_user['user_id'];

            #save Data
            $form1->save();
        }
        
        $response = [
            'form1' => $form1,
            'count_duplicate' => $countDuplicate
        ];
        return response($response, 200);
    }
}
