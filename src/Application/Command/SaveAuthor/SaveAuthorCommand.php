<?php

declare(strict_types=1);


namespace App\Application\Command\SaveAuthor;


class SaveAuthorCommand
{
    private string $authorId;
    private string $authorName;
    private string $authorSurname;

    public function __construct(string $authorId, string $authorName, string $authorSurname)
    {
        $this->authorId = $authorId;
        $this->authorName = $authorName;
        $this->authorSurname = $authorSurname;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getAuthorSurname(): string
    {
        return $this->authorSurname;
    }
}