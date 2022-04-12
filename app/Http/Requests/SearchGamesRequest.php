<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchGamesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gameName' => 'required', // TODO: validation rules (if any)
            'gameMode' => 'required',
        ];
    }
}
