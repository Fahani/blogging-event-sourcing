<?php

declare(strict_types=1);


namespace App\Domain\Aggregate;


use App\Domain\Event\AuthorWasCreatedEvent;
use App\Domain\VO\Name;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\UuidInterface;

class Author extends EventSourcedAggregateRoot
{
    private UuidInterface $id;
    private Name $name;

    public static function create(UuidInterface $id, Name $name): self
    {
        $author = new self();
        $author->apply(new AuthorWasCreatedEvent($id, $name));
        return $author;
    }

    protected function applyAuthorWasCreatedEvent(AuthorWasCreatedEvent $event): void
    {
        $this->id = $event->getId();
        $this->name = $event->getName();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getAggregateRootId(): string
    {
        return $this->id->toString();
    }

    public function getName(): Name
    {
        return $this->name;
    }

}
