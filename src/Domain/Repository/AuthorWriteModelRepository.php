<?php

declare(strict_types=1);


namespace App\Domain\Repository;


use App\Domain\Aggregate\Author;
use App\Domain\Exception\DomainEntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface AuthorWriteModelRepository
{
    public function save(Author $author): void;

    /**
     * @param UuidInterface $id
     * @return Author
     * @throws DomainEntityNotFoundException
     */
    public function findOrFailById(UuidInterface $id): Author;
}
