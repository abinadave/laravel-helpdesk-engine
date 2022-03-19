<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\AddedRole;
class RoleController extends Controller
{
    public function addRoleToUser(Request $request){
        #DB added_roles: id, role_id, user_id, created_at, updated_at
        #Request->all() current_selected_user_id: "5", role_id: 2
        $model = new AddedRole;
        $model->role_id = $request->role_id;
        $model->user_id = $request->current_selected_user_id;
        $model->save();
        return response()->json($model);
        // return $request->all();
    }
    public function fetchRolesOfSpecificUserById(Request $request){
        $roles = $this->getRoles($request->user_id);
        return response()->json($roles);
    }
    public function fetchAllRoles(){
        $roles = Role::all();
        return response()->json($roles);
    }
    public function fetchAddedRolesByUserId(Request $request){
        $added_roles = $this->getRoles($request->user_id);
        return response()->json($added_roles);
    }
    private function getRoles($user_id){
        return DB::table('added_role_views')->where('user_id', $user_id)->get();
    }
}
