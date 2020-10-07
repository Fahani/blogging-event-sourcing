<?php

declare(strict_types=1);


namespace App\Domain\ReadModel;


use App\Domain\Exception\DomainEntityNotFoundException;
use Broadway\ReadModel\Identifiable;
use Ramsey\Uuid\UuidInterface;

interface PostReadModelRepository
{
    public function save(PostReadModel $post): void;

    /**
     * @param UuidInterface $id
     * @return PostReadModel
     * @throws DomainEntityNotFoundException
     */
    public function findOrFailById(UuidInterface $id): Identifiable;
}
