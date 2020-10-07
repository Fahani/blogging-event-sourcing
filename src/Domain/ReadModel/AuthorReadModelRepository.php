<?php

declare(strict_types=1);


namespace App\Domain\ReadModel;


use App\Domain\Exception\DomainEntityNotFoundException;
use Broadway\ReadModel\Identifiable;
use Ramsey\Uuid\UuidInterface;

interface AuthorReadModelRepository
{
    public function save(AuthorReadModel $post): void;

    /**
     * @param UuidInterface $id
     * @return AuthorReadModel
     * @throws DomainEntityNotFoundException
     */
    public function findOrFailById(UuidInterface $id): Identifiable;
}
