<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendPasswordResetLinkRequest;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetController extends Controller
{
    public function showForgotForm(): Response
    {
        return Inertia::render('Auth/ForgotPassword', []);

    }

    public function sendResetLink(SendPasswordResetLinkRequest $request): RedirectResponse
    {
        $token = Str::random(60);


        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::to($request->input('email'))->queue(new PasswordResetMail($token));

        return back()->with('message', 'Reset link sent to your email!');
    }


    public function showResetForm(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $request->query('token'),
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): Redirector|RedirectResponse
    {

        $reset = DB::table('password_reset_tokens')->where([
            ['email', $request->input('email')],
            ['token', $request->input('token')],
        ])->first();

        if (!$reset) {
            return back()->withErrors(['message' => 'Invalid or expired token']);
        }

        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['message' => 'Token has expired, please request a new one.']);
        }

        $user = User::query()
            ->where('email', $request->input('email'))
            ->first();

        $user->update(['password' => $request->input('password')]);

        DB::table('password_reset_tokens')
            ->where('email', $request->input('email'))
            ->delete();

        return redirect('/login')->with('message', 'Password has been reset!');
    }
}
