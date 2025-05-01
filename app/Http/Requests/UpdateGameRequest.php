<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
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
            "team_1_id" => "integer",
            "team_2_id" => "integer",
            "team_1_score" => "integer",
            "team_2_score" => "integer",
            "status" => "string",
            "game_date" => "date",
            "game_start" => "date",
            "game_end" => "date",
        ];
    }
}
