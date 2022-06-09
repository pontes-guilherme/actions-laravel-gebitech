<?php

namespace App\Contracts\Actions;

use App\Models\User;

interface SendOnboardEmailContract
{
    public function __invoke(User $user);
}
