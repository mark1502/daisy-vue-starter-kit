<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Welcome'))->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');

    Route::prefix('settings')->group(function () {
        Route::get('/profile', fn () => Inertia::render('Settings/Profile'))->name('profile.edit');
        Route::get('/password', fn () => Inertia::render('Settings/Password'))->name('password.edit');
        Route::get('/account', fn () => Inertia::render('Settings/DeleteAccount'))->name('account.edit');

        Route::delete('/account', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'password' => ['required', 'current_password'],
            ]);

            $user = $request->user();
            Auth::logout();
            $user->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        })->name('profile.destroy');
    });
});
