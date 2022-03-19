<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PsgcViews;
class PsgcController extends Controller
{
    public function getUserPsgcViews(Request $request){
        $user_id = $request->user_id;
        $psgc_view = PsgcViews::where('user_id', $user_id)->first();
        return response()->json($psgc_view);
    }
    public function brgys(Request $request){
        $citymunCode = $request->citymunCode;
        $lib_brgy = DB::table('lib_brgy')->where('citymunCode', $citymunCode)->get();
        $response = [
            'lib_brgy' => $lib_brgy
        ];
        return response($response, 200);
    }
    public function lgus(Request $request){
        $provCode = $request->provCode;
        $lib_mun = DB::table('lib_mun')->where('provCode', $provCode)->get();
        $response = [
            'lib_mun' => $lib_mun
        ];
        return response($response, 200);
    }
    public function provinces(){
        #Get all provinces from PSGC Lib_provinces
        $provinces = DB::table('lib_province')->where('regCode', 8)->get();
        $response = [
            'provinces' => $provinces
        ];
        return response($response, 200);
    }
}
