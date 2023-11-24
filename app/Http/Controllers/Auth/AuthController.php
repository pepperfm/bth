<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\LoginRequest;

class AuthController
{
    /**
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function showLoginForm(): \Illuminate\Contracts\Support\Responsable
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * @param \App\Http\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(\App\Providers\RouteServiceProvider::HOME);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        \Auth::logout();

        $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return to_route('login');
    }
}
