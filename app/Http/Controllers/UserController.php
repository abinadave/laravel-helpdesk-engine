<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

#models
use App\Models\User;
use App\Models\UserPsgc;

#events
use App\Events\UserWasConfirmed;
class UserController extends Controller
{
    public function updateUser(Request $request){
        // brgy: "83747008"
        // city_mun: "83747"
        // current_selected_user_id: "18"
        // password: "test7"
        // province: "837"
        // username: "test7"
        $status_code = 200;
        $response = [];
        $fieds = $request->validate([
            'email' => 'required',
            'username' => 'required',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'mobile' => 'required|string',
            'gender' => 'required|string',
            'password' => 'required|string'
        ]);
        $countEmail = User::where('email', $request->email)
                    ->where('id', '<>', $request->current_selected_user_id)
                    ->count();
        $countUsername = User::where('username', $request->username)
                    ->where('id', '<>', $request->current_selected_user_id)
                    ->count();
        
        if($countEmail || $countUsername){
            $status_code = 422;
            $response = [
                'count_email' => $countEmail,
                'count_username' => $countUsername
            ];
        }else {
            $user = User::findOrFail($request->current_selected_user_id);
            $user->firstname = $request->firstname;
            $user->middlename = $request->middlename;
            $user->lastname = $request->lastname;
            $user->dateofbirth = $request->birthdate;
            $user->gender = $request->gender;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->save();  
            $status_code = 200;
            $response = [
                'count_email' => $countEmail,
                'count_username' => $countUsername,
                'user' => $user,
                'user_view_updated' => DB::table('user_pagination_views')
                                       ->where('id', $request->current_selected_user_id)
                                       ->first()
            ];
        }
        return response($response, $status_code);
        // $respNum = ($countEmail) ? 422 : 200;
        // return response($response, $respNum);

       
    }
    public function confirmAccount(Request $request){
        $user_id = $request->id;
        $user = User::findOrFail($user_id);
        $user->confirmation_status = 1;
        $rsUpdated = $user->save();
        $response = [
            'updated' => $rsUpdated,
            'user' => $user
        ];
        // Log::info('user was confirmed user user id: '. $user->id);
        // event(new UserConfirmed($user));
        UserWasConfirmed::dispatch($user);
        return response($response, 200);
    }
    public function checkemailDuplicate(Request $request){
        $email = $request->email;
        $request->validate([
            'email' => 'unique:users|max:255|email'
        ]);
        // return $request->all();
    }
    public function fetchPaginate(){
        $paginatedUsers = DB::table('user_pagination_views')->orderBy('id','desc')->paginate(15);
        // $paginatedUsers = User::orderBy('id','desc')->paginate(15);
        return response()->json($paginatedUsers);
    }
    public function insert(Request $request){
        // birthdate: "2022-01-03"
        // brgy: 83702008
        // city_mun: 83702
        // email: "oi@gmail.com"
        // firstname: "awerawer"
        // gender: "m"
        // lastname: "awerawer"
        // middlename: "awerawer"
        // mobile: "234234234234"
        // password: "oiuawerurrwer"
        // province: 837
        // username: "oiuaweroiu"
        // $user = new User;
        // $user->firstname = $request->firstname;
        // return $request->all();

        $user = new User;
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->name = $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname;
        $user->dateofbirth = $request->birthdate;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;

        #Account details
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        $userPsgc = $this->insertUserPsgc($user->id, $request->province, $request->city_mun, $request->brgy);
        $user_view = DB::table('user_pagination_views')->where('id', $user->id)->first();
        $response = [
            'user' => $user,
            'user_psgc' => $userPsgc,
            'user_view' => $user_view
        ];
        return response($response, 200);
    }
    public function insertUserPsgc($user_id, $province, $city_mun, $brgy){
        $model = new UserPsgc;
        $model->user_id = $user_id;
        $model->province = $province;
        $model->city_mun = $city_mun;
        $model->brgy = $brgy;
        $model->save();
    }
    public function testApiRoute(){
        return response()->json([
            'test' => 'successful',
            'code' => 200
        ], 200);
    }
}
