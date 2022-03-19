<?php

namespace App\Listeners;

use App\Events\UserWasConfirmed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

#Models 
use App\Models\AddedRole;
class GrantBarangayRoleForConfirmedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserWasConfirmed  $event
     * @return void
     */
    public function handle(UserWasConfirmed $event)
    {
        // Log::info("Hit in Listener: GrantBarangayRoleForConfirmedUser");
        $user = $event->user;
        $user_id = $user->id;

        #Create a role for newly confirmed account
        $added_role = new AddedRole;
        $added_role->user_id = $user_id;
        $added_role->role_id = 2;
        $added_role->save();
        // Log::info('user id '. $user->id);
    }
}
