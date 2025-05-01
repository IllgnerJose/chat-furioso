<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
        return [
            "team_1_id" => "required|integer|different:team_2_id||exists:teams,id",
            "team_2_id" => "required|integer|different:team_1_id|exists:teams,id",
            "game_date" => "required|date",
        ];
    }
}
