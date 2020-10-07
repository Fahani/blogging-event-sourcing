<?php

declare(strict_types=1);


namespace App\Domain;


use App\Domain\Exception\DomainException;

class CommonValidator
{
    public static function validateNotEmptyString(string $string, $message): void
    {
        if (empty($string)) {
            throw new DomainException($message);
        }
    }
}