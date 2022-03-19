<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

#Imports
use Illuminate\Support\Facades\Auth;

#Models
use App\Models\DynamicForm;
use App\Models\UserPsgc;
use Illuminate\Support\Facades\DB;
use App\Models\DynamicFormValue;

class DynamicFormController extends Controller
{
    public function fetchByProvCityMunBrgy(){
        $user_psgc = $this->getUserPsgc();
        $paginate = DB::table('dynamic_form_views')->where('province', $user_psgc->province)
                        ->where('city_mun', $user_psgc->city_mun)
                        ->where('brgy', $user_psgc->brgy)
                        ->paginate(15);
        // $dfm_values = DynamicFormValue::where('dynamic_forms_id', )
        $response = [
            'paginate' => $paginate
        ];
        return response($response, 201);
    }
    public function validateBeforeInsert(Request $request){
        $user_psgc = $this->getUserPsgc();
        $count = DynamicForm::where('year', $request->year)->where('month', $request->month)
                    ->where('province', $user_psgc->province)
                    ->where('city_mun', $user_psgc->city_mun)
                    ->where('brgy', $user_psgc->brgy)
                    ->count();
        $response = [
            'count' => $count
        ];
        return response($response, 200);
    }
    private function getUserPsgc(){
        // {"id":1,"user_id":"1","province":"837","city_mun":"83747","brgy":"83747152","created_at":"2022-02-16T07:53:25.000000Z","updated_at":"2022-02-16T07:53:25.000000Z"}
        return UserPsgc::where('user_id', Auth::id())->first();
    }
    public function insertDynamicForm(Request $request){
        $user_psgc = $this->getUserPsgc();
        $dynamic_form = new DynamicForm;
        
        $dynamic_form->province = $user_psgc->province;
        $dynamic_form->city_mun = $user_psgc->city_mun;
        $dynamic_form->brgy = $user_psgc->brgy;
        $dynamic_form->forms_table_id = 1;
        $dynamic_form->encoder = Auth::id();
        $dynamic_form->year = $request->year;
        $dynamic_form->month = $request->month;
        $dynamic_form->save();
        $response = [
            'dynamic_form' => $dynamic_form
        ];
        return response($response, 201);
        // return $user_psgc;
        // return $request->all();
    }

    #User PSGC
    // brgy: "83747152"
    // city_mun: "83747"
    // created_at: "2022-02-16T07:53:25.000000Z"
    // id: 1
    // province: "837"
    // updated_at: "2022-02-16T07:53:25.000000Z"
    // user_id: "1"
}
