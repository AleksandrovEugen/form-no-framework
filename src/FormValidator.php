<?php

namespace AleksandrovEugen\TestForm;

use AleksandrovEugen\TestForm\Core\BaseValidator;

class FormValidator extends BaseValidator
{
    protected function getRules(): array
    {
        return [
            'email'       => 'required|email',
            'phoneNumber' => 'required|numeric', // TODO: validate phone
            'message'     => 'nullable',
        ];
    }
}