<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\CurrentPassword;
use Illuminate\Contracts\Validation\Validator;
use Alert;

class UpdatePasswordRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            Alert::error('Password gagal diubah', 'Perhatikan password anda');
        }
        return back()->withErrors($validator)->withInput();
    }
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => ['required', 'string', new CurrentPassword()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
