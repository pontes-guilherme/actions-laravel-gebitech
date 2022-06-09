<?php

namespace App\Console\Commands;

use App\Actions\Auth\ApproveUser;
use App\Actions\Auth\RegisterUser;
use App\Actions\Onboarding\OnboardUser;
use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Factory;

class RegisterUserCommand extends Command
{
    protected $signature = 'register {email?} {name?} {password?}';

    protected $description = 'Register a new user.';


    public function handle(Factory $validator, OnboardUser $OnboardUserAction, ApproveUser $approveUserAction): int
    {
        $data = $this->data();

        $user = $OnboardUserAction($data);
        $approveUserAction($user);

        $this->line("User [{$user->email}] has been registered.");

        return Command::SUCCESS;
    }

    private function data(): array
    {
        return [
            'email' => $this->argument('email') ?? $this->ask('What is the user\'s email?'),
            'name' => $this->argument('name') ?? $this->ask('What is the user\'s name?'),
            'password' => $this->argument('password') ?? "qwer1234",
        ];
    }
}
