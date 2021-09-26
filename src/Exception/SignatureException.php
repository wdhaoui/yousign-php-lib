<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Exception;

class SignatureException extends \RuntimeException
{
    private $errors;

    public function __construct(int $code, string $message = null, \Exception $previous = null, array $errors = [])
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}
