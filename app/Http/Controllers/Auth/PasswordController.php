<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', \Illuminate\Validation\Rules\Password::defaults(), 'confirmed'],
        ], [

            'current_password.required' => 'Por favor, introduza a sua palavra-passe atual.',
            'current_password.current_password' => 'A palavra-passe atual está incorreta.',
            'password.required' => 'Por favor, introduza uma nova palavra-passe.',
            'password.min' => 'A nova palavra-passe deve ter pelo menos 8 carateres.',
            'password.confirmed' => 'A confirmação da nova palavra-passe não coincide.',
        ]);

        $request->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
