<?php

namespace App\Actions\Onboarding;

use App\Actions\Auth\RegisterUser;
use App\Actions\Notifications\SendOnboardEmail;
use App\Contracts\Actions\ApproveUserContract;
use App\Contracts\Actions\OnboardUserContract;
use App\Contracts\Actions\RegisterUserContract;
use App\Contracts\Actions\SendOnboardEmailContract;

class OnboardAndApproveUser implements OnboardUserContract
{
    private $registerUserAction;
    private $sendOnboardEmailAction;
    private $approveUserAction;

    public function __construct(
        RegisterUserContract $registerUserAction,
        SendOnboardEmailContract $sendOnboardEmailAction,
        ApproveUserContract $approveUserAction
    ) {
        $this->registerUserAction = $registerUserAction;
        $this->sendOnboardEmailAction = $sendOnboardEmailAction;
        $this->approveUserAction = $approveUserAction;
    }

    public function __invoke($data)
    {
        $user = ($this->registerUserAction)($data);
        ($this->approveUserAction)($user);
        ($this->sendOnboardEmailAction)($user);

        return $user;
    }
}
