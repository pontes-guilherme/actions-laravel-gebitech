<?php

namespace App\Actions\Auth;

use App\Contracts\Actions\ApproveUserContract;
use App\Models\User;

class ApproveUser implements ApproveUserContract
{
    public function __invoke(User $user)
    {
        // COMPLEX STUFF
        sleep(10);
        // END COMPLEX STUFF

        $user->update(['approved' => true]);
    }
}
