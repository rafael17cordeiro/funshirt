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

        // --- INÍCIO DO CÓDIGO DO AVATAR ---
        if ($request->hasFile('photo')) {
            // Valida se é uma imagem e o tamanho máximo (2MB)
            $request->validate(['photo' => 'image|max:2048']);

            // Apaga a foto antiga do servidor se existir, para não ocupar espaço morto
            if ($user->photo_url) {
                Storage::disk('public')->delete('photos/' . $user->photo_url);
            }

            // Guarda a nova foto na pasta correta (storage/app/public/photos)
            $path = $request->file('photo')->store('photos', 'public');

            // Guarda APENAS o nome do ficheiro na base de dados (ex: 'asd98a7sd.jpg')
            $user->photo_url = basename($path);
        }
        // --- FIM DO CÓDIGO DO AVATAR ---

        // Guarda o User (agora com o photo_url atualizado, se enviou foto)
        $user->save();

        // 2. Atualiza os dados do Customer se aplicável
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
