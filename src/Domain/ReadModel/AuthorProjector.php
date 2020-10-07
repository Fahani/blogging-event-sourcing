<?php

declare(strict_types=1);


namespace App\Domain\ReadModel;


use App\Domain\Event\AuthorWasCreatedEvent;
use Broadway\ReadModel\Projector;

class AuthorProjector extends Projector
{
    private AuthorReadModelRepository $repository;

    public function __construct(AuthorReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function applyAuthorWasCreatedEvent(AuthorWasCreatedEvent $event): void
    {
        $author = new AuthorReadModel($event->getId(), $event->getName());
        $this->repository->save($author);
    }

}
