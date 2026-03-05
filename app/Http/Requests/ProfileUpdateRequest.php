<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('users', 'mobile')->ignore($this->user()->id),
            ],

            'whatsapp_no' => ['nullable','digits:10'],
            'profile_pic' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'documents'   => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096']
        ];
    }
}
