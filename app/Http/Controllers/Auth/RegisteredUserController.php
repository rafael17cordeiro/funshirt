<?php

namespace App\Http\Controllers\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'gender' => ['required', 'in:M,F'], // <-- Nova regra: obrigatório e só aceita M ou F
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // DB Transaction: Cria o User e o Customer ou cancela ambos em caso de erro
        $user = DB::transaction(function () use ($request) {

            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 'C',
                'gender' => $request->gender, // <-- Guardar o género escolhido
                'blocked' => 0, // <-- Garantir que o utilizador não está bloqueado
            ]);

            Customer::create([
                'id' => $newUser->id,
            ]);

            return $newUser;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
