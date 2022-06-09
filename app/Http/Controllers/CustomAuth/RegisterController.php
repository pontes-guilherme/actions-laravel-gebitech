<?php

namespace App\Http\Controllers\CustomAuth;

use App\Actions\Auth\RegisterUser;
use App\Actions\Onboarding\OnboardUser;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('custom-auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, OnboardUser $onboardUserAction)
    {
        $user = $onboardUserAction($request->all());

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
