<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }
    /**
     * Send the password reset link.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'If an account exists with that email address, a password reset link has been sent.'
            );
        }
        return back()->withErrors([
            'email' => 'Unable to send the password reset link. Please check the email address and try again.',
        ]);
    }
}