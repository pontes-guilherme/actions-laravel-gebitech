<?php

namespace App\Actions\Notifications;

use App\Contracts\Actions\SendOnboardEmailContract;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendOnboardEmail implements SendOnboardEmailContract
{
    public function __invoke(User $user)
    {
        Mail::to($user)->send(new WelcomeMail($user));
    }
}
