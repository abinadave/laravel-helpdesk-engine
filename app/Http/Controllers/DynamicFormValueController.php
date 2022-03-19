<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

#Imports
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

#Models
use App\Models\UserPsgc;
use App\Models\DynamicFormValue;

class DynamicFormValueController extends Controller
{
    public function fetchByDynamicFormsId(Request $request){
        $ids = $request->ids;
        $dynamic_form_values = DynamicFormValue::whereIn('dynamic_forms_id', $ids)->get();
        $response = [
            'dynamic_form_values' => $dynamic_form_values
        ];
        return response($response, 201);
    }
    public function fetchByProvCityMunBrgy(){
        // $user_psgc = $this->getUserPsgc();
        // $dynamic_form_value_views = DB::table('dynamic_form_value_views')->where('province', $user_psgc->province)
        //                 ->where('city_mun', $user_psgc->city_mun)
        //                 ->where('brgy', $user_psgc->brgy)
        //                 ->get();
        // $response = [
        //     'dynamic_form_value_views' => $dynamic_form_value_views
        // ];
        // return response($response, 201);
    }
    private function getUserPsgc(){
        // {"id":1,"user_id":"1","province":"837","city_mun":"83747","brgy":"83747152","created_at":"2022-02-16T07:53:25.000000Z","updated_at":"2022-02-16T07:53:25.000000Z"}
        return UserPsgc::where('user_id', Auth::id())->first();
    }
    public function insert(Request $request){
        #Get PSGC of User
        $user_psgc = UserPsgc::where('user_id', Auth::id())->first();
        // Log::info('User PSGC', ['user_psgc' => $user_psgc]);
         #These are the Payload request parameters
        $arr = $request->arr;
        $dynamic_forms_id = $request->dynamic_forms_id;
        #End of Payload request parameters

        $saved_models = [];
        foreach ($arr as $model) {
            $dfm = new DynamicFormValue;
            $dfm->dynamic_forms_id = $dynamic_forms_id;
            $dfm->key = $model['key'];
            $dfm->value = $model['value'];
            $dfm->save();
            array_push($saved_models, $dfm);
        }
        $response = [
            'inserted_dynamic_form_values' => $saved_models,
        ];
        return response($response, 200);
    }
    public function insertFinal(){
        // Log::info('This is the request payload', ['request all' => $request->all()]);
        #These are the Payload request parameters
        $arr = $request->arr;
        $dynamic_forms_id = $request->dynamic_forms_id;
        #End of Payload request parameters

        $saved_models = [];
        foreach ($arr as $model) {
            $dfm = new DynamicFormValue;
            $dfm->dynamic_forms_id = $dynamic_forms_id;
            $dfm->key = $model['key'];
            $dfm->value = $model['value'];
            $dfm->save();
            array_push($saved_models, $dfm);
        }
        $response = [
            'inserted_dynamic_form_values' => $saved_models,
        ];
        return response($response, 200);
    }
}
