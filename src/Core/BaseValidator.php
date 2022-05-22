<?php

namespace AleksandrovEugen\TestForm\Core;

use Psr\Http\Message\RequestInterface;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class BaseValidator implements FormValidatorInterface
{
    public function __construct(
        private Validator $validator,
        private RequestInterface $request,
    ){}

    protected function getRules(): array
    {
        return [];
    }

    public function getValidation(): Validation
    {
        return $this->validator->validate($this->request->getParsedBody(), $this->getRules());
    }
}