<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Atualiza os dados do User (name, email)
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }


        if ($request->hasFile('photo')) {

            $request->validate(['photo' => 'image|max:2048']);


            if ($user->photo_url) {
                Storage::disk('public')->delete('photos/' . $user->photo_url);
            }


            $path = $request->file('photo')->store('photos', 'public');


            $user->photo_url = basename($path);
        }



        $user->save();


        if ($user->user_type === 'C' && $user->customer) {
            $user->customer->update([
                'nif' => $request->nif,
                'address' => $request->address,
                'default_payment_type' => $request->default_payment_type,
                'default_payment_ref' => $request->default_payment_ref,
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
