<?php

namespace Rabcreatives\Oppwa\Http\Requests;

use Rabcreatives\Oppwa\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class ResponseRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required'],
            'resourcePath' => ['required']
        ];
    }
}
