<?php

declare(strict_types=1);


namespace App\Domain\VO;


class Description
{
    private string $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}