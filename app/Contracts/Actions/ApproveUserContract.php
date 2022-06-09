<?php

namespace App\Contracts\Actions;

use App\Models\User;

interface ApproveUserContract
{
    public function __invoke(User $user);
}
