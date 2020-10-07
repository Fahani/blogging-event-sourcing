<?php

declare(strict_types=1);


namespace App\Domain\Event;


use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Title;
use Ramsey\Uuid\UuidInterface;

class PostWasCreatedEvent extends Event
{
    private UuidInterface $id;
    private UuidInterface $authorId;
    private Title $title;
    private Description $description;
    private Content $content;

    public function __construct(
        UuidInterface $id,
        UuidInterface $authorId,
        Title $title,
        Description $description,
        Content $content
    ) {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;

        parent::__construct($id);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
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

    public static function deserialize(array $data): self
    {
        return new self(
            $data['id'],
            $data['authorId'],
            $data['title'],
            $data['description'],
            $data['content']
        );
    }

    public function specificSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'authorId' => $this->authorId
        ];
    }
}
