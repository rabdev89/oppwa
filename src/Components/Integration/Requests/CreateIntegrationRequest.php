<?php

namespace Rabcreatives\Oppwa\Components\Integration\Requests;

use Rabcreatives\Oppwa\Components\Base\Requests\BaseFormRequest;

class CreateIntegrationRequest extends BaseFormRequest
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
