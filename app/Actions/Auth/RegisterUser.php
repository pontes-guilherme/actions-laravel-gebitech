<?php

namespace App\Actions\Auth;

use App\Actions\Notifications\SendOnboardEmail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Console\Command;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class RegisterUser
{
    use AsAction;

    public string $commandSignature = 'register {email?} {name?} {password?}';

    public string $commandDescription = 'Register a new user.';

    private $sendOnboardEmail;

    public function __construct(SendOnboardEmail $sendOnboardEmail)
    {
        $this->sendOnboardEmail = $sendOnboardEmail;
    }

    public function asCommand(Command $command): void
    {
        $data = $this->validate([
            'email' => $command->argument('email') ?? $command->ask('What is the user\'s email?'),
            'name' => $command->argument('name') ?? $command->ask('What is the user\'s name?'),
            'password' => $command->argument('password') ?? "qwer1234",
        ]);

        $user = $this->handle($data);

        ($this->sendOnboardEmail)($user);

        $command->info("User [{$user->email}] has been registered.");
    }

    public function asController(HttpRequest $request)
    {
        $user = $this->handle($this->validate($request->all()));

        ($this->sendOnboardEmail)($user);

        Auth::login($user);

        if ($request->expectsJson()) {
            return response()->json($user);
        }

        return redirect(RouteServiceProvider::HOME);
    }

    public function handle(array $data): User
    {
        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }

    public function validate(array $data)
    {
        $data = Validator::validate($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        return $data;
    }
}
