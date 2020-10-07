<?php

declare(strict_types=1);


namespace App\Infrastructure\Persistence\Broadway\ReadModel;


use App\Domain\Exception\DomainEntityNotFoundException;
use App\Domain\ReadModel\PostReadModel;
use App\Domain\ReadModel\PostReadModelRepository;
use Broadway\ReadModel\Identifiable;
use Broadway\ReadModel\Repository;
use Ramsey\Uuid\UuidInterface;

class BroadwayPostReadModelRepository implements PostReadModelRepository
{

    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function save(PostReadModel $post): void
    {
        $this->repository->save($post);
    }

    /**
     * @inheritDoc
     */
    public function findOrFailById(UuidInterface $id): Identifiable
    {
        $readModel = $this->repository->find($id->toString());

        if ($readModel === null || get_class($readModel) !== PostReadModel::class) {
            throw new DomainEntityNotFoundException("PostReadModel not found with id $id");
        }
        return $readModel;

    }
}
