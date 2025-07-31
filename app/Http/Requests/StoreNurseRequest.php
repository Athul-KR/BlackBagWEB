<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNurseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $nurse_uuid = $this->route('uuid');
        return [

            'name' => 'required',
            'email' => 'required|email',
            // 'email' => 'required|email|unique:clinic_users,email,' . $nurse_uuid . ',clinic_user_uuid',
            'phone' => 'required|digits:10',
            'countrycode' => 'required',
            'department' => 'required',
            'qualification' => 'required',
            'specialties' => 'required',

        ];
    }
}
