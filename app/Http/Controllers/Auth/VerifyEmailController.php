<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
                $user = $request->user();
                if ($user->role === 'Admin') {
                    return redirect()->intended(route('admin.dashboard').'?verified=1');
                } elseif ($user->role === 'Hr') {
                    return redirect()->intended(route('hr.dashboard').'?verified=1');
                } elseif ($user->role === 'Gateman') {
                    return redirect()->intended(route('gateman.dashboard').'?verified=1');
                }
                return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
            $user = $request->user();
            if ($user->role === 'Admin') {
                return redirect()->intended(route('admin.dashboard').'?verified=1');
            } elseif ($user->role === 'Hr') {
                return redirect()->intended(route('hr.dashboard').'?verified=1');
            } elseif ($user->role === 'Gateman') {
                return redirect()->intended(route('gateman.dashboard').'?verified=1');
            }
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
