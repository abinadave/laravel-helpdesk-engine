<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndividualVaccination;
class IndividualVaccinationController extends Controller
{
    public function fetchByProvCityMunBrgy(Request $request){
        $data = IndividualVaccination::where('province', $request->province)
                ->where('city_mun', $request->city_mun)
                ->where('brgy', $request->brgy)
                ->orderBy('id', 'desc')
                ->get();
        return response()->json($data);
    }
    public function insert(Request $request){
        #Current Logged In user with Province, CityMun and Brgy Codes
        $current_psgc_user = $request->current_psgc_user;

        $model = new IndividualVaccination;

        $model->firstname = $request->firstname;
        $model->middlename = $request->middlename;
        $model->lastname = $request->lastname;
        $model->birthdate = $request->birthdate;

        $vaccination_type = $request->vaccination_type;

        $model->unvaccinated = ($vaccination_type == 'unvaccinated') ? 1 : 0;
        $model->partially_vaccinated = ($vaccination_type == 'partially-vaccinated') ? 1 : 0;
        $model->fully_vaccinated = ($vaccination_type == 'fully-vaccinated-without-booster' || $vaccination_type == 'fully-vaccinated-with-booster') ? 1 : 0;
        $model->with_bootster_shot = ($vaccination_type == 'fully-vaccinated-with-booster') ? 1 : 0;
        
        #Dates
        $model->date_of_vaccination_1st_dose = $request->date_of_vaccination_1st_dose;
        $model->date_of_vaccination_2nd_dose = $request->date_of_vaccination_2nd_dose;
        $model->date_of_vaccination_booster_shot = $request->date_of_vaccination_booster_shot;
        
        #booster Brands
        $model->brand_primary_series = $request->first_second_dose_brand;
        $model->brand_booster_shot = $request->booster_brand;

        $model->province = $current_psgc_user['provCode'];
        $model->city_mun = $current_psgc_user['citymunCode'];
        $model->brgy = $current_psgc_user['brgy'];
        $model->encoded_by_user_id = $current_psgc_user['user_id'];

        $model->save();
        
        $response = [
            'individual_vaccination' => $model
        ];
        return response($response, 200);
        // booster_brand: null
        // date_of_vaccination_1st_dose: "2022-01-10"
        // date_of_vaccination_2nd_dose: ""
        // date_of_vaccination_booster_shot: ""
        // first_second_dose_brand: 3
        // firstname: "dave"
        // lastname: "abina"
        // middlename: "p."
        // vaccination_type: "partially-vaccinated"
        // return $request->all();
    }
}
