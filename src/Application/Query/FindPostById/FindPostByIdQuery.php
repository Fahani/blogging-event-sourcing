<?php

declare(strict_types=1);


namespace App\Application\Query\FindPostById;


class FindPostByIdQuery
{
    private string $id;
    private bool $includeAuthor;

    public function __construct(string $id, bool $includeAuthor = false)
    {
        $this->id = $id;
        $this->includeAuthor = $includeAuthor;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isIncludeAuthor(): bool
    {
        return $this->includeAuthor;
    }

}
