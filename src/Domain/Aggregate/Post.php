<?php

declare(strict_types=1);


namespace App\Domain\Aggregate;

use App\Domain\Event\PostWasCreatedEvent;
use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Title;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\UuidInterface;

class Post extends EventSourcedAggregateRoot
{
    private UuidInterface $id;
    private UuidInterface $authorId;
    private Title $title;
    private Description $description;
    private Content $content;

    public static function create(
        UuidInterface $id,
        UuidInterface $authorId,
        Title $title,
        Description $description,
        Content $content
    ): self {
        $post = new self();
        $post->apply(new PostWasCreatedEvent($id, $authorId, $title, $description, $content));
        return $post;
    }

    protected function applyPostWasCreatedEvent(PostWasCreatedEvent $event): void
    {
        $this->id = $event->getId();
        $this->authorId = $event->getAuthorId();
        $this->title = $event->getTitle();
        $this->description = $event->getDescription();
        $this->content = $event->getContent();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getAggregateRootId(): string
    {
        return $this->id->toString();
    }

    public function getAuthorId(): UuidInterface
    {
        return $this->authorId;
    }


    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getContent(): Content
    {
        return $this->content;
    }
}
