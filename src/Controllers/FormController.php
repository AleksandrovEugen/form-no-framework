<?php
namespace AleksandrovEugen\TestForm\Controllers;

use AleksandrovEugen\TestForm\Core\BaseController;
use AleksandrovEugen\TestForm\Core\FormValidatorInterface;
use AleksandrovEugen\TestForm\Services\FormService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FormController extends BaseController
{
    public function __construct(
        protected FormValidatorInterface $validator,
        protected FormService $formService
    ){}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $validation = $this->validator->getValidation();

        if ($validation->fails()) {
            return $this->sendJsonResponse($validation->errors()->firstOfAll(), 400);
        }

        $formData = $validation->getValidatedData();

        $formId = $this->formService->saveForm($formData['email'], $formData['phoneNumber'], $formData['message']);

        return $this->sendJsonResponse(['formId' => $formId], 201);
    }
}