<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisterUserCommand extends Command
{
    protected $signature = 'register {email?} {name?} {password?}';

    protected $description = 'Register a new user.';


    public function handle(Factory $validator): int
    {
        $data = $this->validData($validator);

        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
            'approved' => true,
        ]);

        event(new Registered($user));

        $this->line("User [{$user->email}] has been registered.");

        return Command::SUCCESS;
    }

    private function validData(Factory $validator): array
    {
        return $validator->make($this->data(), [
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ])->validate();
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
