<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if ($this->getMethod() == 'PATCH') {
            $user = User::query()->find(Auth::id());
            return $user->hasAnyRole('admin','employee');
        } elseif ($this->getMethod() == 'POST') {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = User::UserRule;
        if ($this->getMethod() == 'POST') {
            $rules += ['password' => 'required|string|confirmed|min:8'];
        } elseif ($this->getMethod() == 'PATCH') {
            $rules += ['image' => 'nullable|image|mimes:jpeg,jpg,png'];
            if (User::query()->find(Auth::id())->value('job') == 'employee') {
                $rules += ['motto' => 'string|required|max:255'];
            }
        }

        return $rules;
    }
}
