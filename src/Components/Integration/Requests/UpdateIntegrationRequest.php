<?php

namespace Rabcreatives\Oppwa\Components\Integration\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIntegrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'organizaton_id' => ['required'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency_code' => ['required'],
        ];
    }
}
