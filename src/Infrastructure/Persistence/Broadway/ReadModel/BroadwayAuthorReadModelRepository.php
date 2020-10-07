<?php

declare(strict_types=1);


namespace App\Infrastructure\Persistence\Broadway\ReadModel;


use App\Domain\Exception\DomainEntityNotFoundException;
use App\Domain\ReadModel\AuthorReadModel;
use App\Domain\ReadModel\AuthorReadModelRepository;
use Broadway\ReadModel\Identifiable;
use Broadway\ReadModel\Repository;
use Ramsey\Uuid\UuidInterface;

class BroadwayAuthorReadModelRepository implements AuthorReadModelRepository
{

    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function save(AuthorReadModel $author): void
    {
        $this->repository->save($author);
    }

    /**
     * @inheritDoc
     */
    public function findOrFailById(UuidInterface $id): Identifiable
    {
        $readModel= $this->repository->find($id->toString());

        if ($readModel === null || get_class($readModel) !== AuthorReadModel::class) {
            throw new DomainEntityNotFoundException("AuthorReadModel not found with id $id");
        }
        return $readModel;
    }
}
