<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Regras adicionadas para os clientes
            'nif' => ['nullable', 'string', 'size:9'],
            'address' => ['nullable', 'string', 'max:255'],
            'default_payment_type' => ['nullable', 'string', 'in:Visa,PayPal,MB WAY'],
            'default_payment_ref' => ['nullable', 'string', 'max:255'],
        ];
    }
}
