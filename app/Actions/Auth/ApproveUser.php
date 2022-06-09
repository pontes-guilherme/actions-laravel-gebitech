<?php

namespace App\Actions\Auth;

use App\Models\User;

class ApproveUser
{
    public function __invoke(User $user)
    {
        // COMPLEX STUFF
        sleep(10);
        // END COMPLEX STUFF

        $user->update(['approved' => true]);
    }
}
