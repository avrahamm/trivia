<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class LeaveGame
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
     * Handle the  logout event.
     * User record is deleted.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;
        $user->delete();
    }
}
