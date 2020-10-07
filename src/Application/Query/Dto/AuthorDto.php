<?php

declare(strict_types=1);


namespace App\Application\Query\Dto;


use App\Domain\ReadModel\AuthorReadModel;

final class AuthorDto
{
    private string $id;
    private string $name;
    private string $surname;

    public function __construct(string $id, string $name, string $surname)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
    }

    public static function assemble(AuthorReadModel $author): AuthorDto
    {
        return new self($author->getId(), $author->getName()->getName(), $author->getName()->getSurname());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

}
