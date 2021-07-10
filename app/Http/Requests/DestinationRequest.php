<?php

namespace App\Http\Requests;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DestinationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $user = User::query()->find(Auth::id());
        return $user->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = Destination::DestinationRule;
        if ($this->getMethod() == 'PATCH') {
            $rules += ['image' => 'nullable|image|mimes:jpeg,jpg,png'];
        }

        return $rules;
    }
}
