<?php

namespace AleksandrovEugen\TestForm\Services;

use AleksandrovEugen\TestForm\Repositories\FormRepository;
use Throwable;

final class FormService
{
    public function __construct(
        protected FormRepository $formRepository
    ){}

    /**
     * @param string $email
     * @param string $phoneNumber
     * @param string|null $message
     * @return int
     */
    public function saveForm(string $email, string $phoneNumber, string|null $message = null): int
    {
        try {
            $formId = $this->formRepository->saveForm($email, $phoneNumber, $message);
        } catch (Throwable $e) {
            // TODO: Log error message $e->getMessage()
            // Error will be caught above by Whoops\Handler
        }

        return $formId;
    }
}