<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BlockedUser;
use App\Models\User;
class BlockedUserController extends Controller
{
    public function unblockUserById(Request $request){
        $user_id = $request->user_id;
        $model = BlockedUser::where('user_id', $user_id)->first();
        $rsDeleted = $model::destroy($model->id);
        $response = [
            'blocked_user' => $model,
            'rs_deleted' => $rsDeleted,
            'user_view' => DB::table('user_pagination_views')->where('id', $user_id)->first()
        ];
        return response($response, 200);
    }
    public function blockUserByUserId(Request $request){
        $user_id = $request->user_id;
        $blocked_user = new BlockedUser;
        $blocked_user->user_id = $user_id;
        $blocked_user->encoder = Auth::id();
        $blocked_user->save();
        $response = [
            'blocked_user' => $blocked_user
        ];
        return response($response, 200);
    }
}
