<?php

namespace App\Actions\Onboarding;

use App\Actions\Auth\RegisterUser;
use App\Actions\Notifications\SendOnboardEmail;

class OnboardUser
{
    private $registerUserAction;
    private $sendOnboardEmailAction;

    public function __construct(RegisterUser $registerUserAction, SendOnboardEmail $sendOnboardEmailAction)
    {
        $this->registerUserAction = $registerUserAction;
        $this->sendOnboardEmailAction = $sendOnboardEmailAction;
    }

    public function __invoke($data)
    {
        $user = ($this->registerUserAction)($data);
        ($this->sendOnboardEmailAction)($user);

        return $user;
    }
}