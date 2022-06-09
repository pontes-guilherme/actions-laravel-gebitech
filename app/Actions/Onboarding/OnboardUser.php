<?php

namespace App\Actions\Onboarding;

use App\Actions\Auth\RegisterUser;
use App\Actions\Notifications\SendOnboardEmail;
use App\Contracts\Actions\OnboardUserContract;
use App\Contracts\Actions\RegisterUserContract;
use App\Contracts\Actions\SendOnboardEmailContract;

class OnboardUser implements OnboardUserContract
{
    private $registerUserAction;
    private $sendOnboardEmailAction;

    public function __construct(RegisterUserContract $registerUserAction, SendOnboardEmailContract $sendOnboardEmailAction)
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