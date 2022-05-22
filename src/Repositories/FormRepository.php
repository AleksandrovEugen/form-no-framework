<?php

namespace AleksandrovEugen\TestForm\Repositories;

use Atlas\Query\Insert;
use PDO;

class FormRepository
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host=' . $_ENV['APP_DB_HOST']  . ':' . $_ENV['APP_DB_PORT'] . ';dbname=' . $_ENV['APP_DB_DATABASE'],
            $_ENV['APP_DB_USERNAME'],
            $_ENV['APP_DB_PASSWORD']
        );
    }

    /**
     * @param string $email
     * @param string $phoneNumber
     * @param string|null $message
     * @return int
     */
    public function saveForm(string $email, string $phoneNumber, string|null $message = null): int
    {
        $insert = Insert::new($this->pdo);
        $insert->into('forms');
        $insert->columns([
            'email'   => $email,
            'phone'   => $phoneNumber,
            'message' => $message
        ]);

        $insert->perform();

        return $insert->getLastInsertId();
    }
}