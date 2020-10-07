<?php

declare(strict_types=1);


namespace App\Domain\Repository;


use App\Domain\Aggregate\Post;
use App\Domain\Exception\DomainEntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface PostWriteModelRepository
{
    public function save(Post $post): void;

    /**
     * @param UuidInterface $id
     * @return Post
     * @throws DomainEntityNotFoundException
     */
    public function findOrFailById(UuidInterface $id): Post;
}
