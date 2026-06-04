<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // Traduzido para Português
            throw ValidationException::withMessages([
                'email' => 'As credenciais fornecidas não são válidas.',
            ]);
        }

        // --- INÍCIO DA NOSSA VERIFICAÇÃO DE BLOQUEIO ---
        // ATENÇÃO: Substitui 'blocked' pelo nome exato da tua coluna na base de dados 
        // (ex: 'is_blocked', 'estado', 'status', etc.)
        if (Auth::user()->blocked) {

            // 1. Fazemos logout imediato ao utilizador
            Auth::logout();

            // 2. Devolvemos um erro a explicar o motivo
            throw ValidationException::withMessages([
                'email' => 'A sua conta encontra-se bloqueada. Por favor, contacte a administração.',
            ]);
        }
        // --- FIM DA VERIFICAÇÃO ---

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());
        $minutes = ceil($seconds / 60);

        // Traduzido e adaptado para Português
        throw ValidationException::withMessages([
            'email' => 'Demasiadas tentativas de login. Por favor, tente novamente em ' . $minutes . ' minuto(s).',
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}