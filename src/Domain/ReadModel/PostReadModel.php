<?php

declare(strict_types=1);


namespace App\Domain\ReadModel;


use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Name;
use App\Domain\VO\Title;
use Broadway\ReadModel\Identifiable;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PostReadModel implements Identifiable, Serializable
{
    private UuidInterface $id;
    private Title $title;
    private Description $description;
    private Content $content;
    private AuthorReadModel $authorReadModel;

    public function __construct(
        UuidInterface $id,
        Title $title,
        Description $description,
        Content $content,
        AuthorReadModel $author
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->authorReadModel = $author;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public static function deserialize(array $data)
    {
        return new self(
            Uuid::fromString($data['id']),
            new Title($data['title']),
            new Description($data['description']),
            new Content($data['content']),
            new AuthorReadModel(
                Uuid::fromString($data['author']['id']),
                new Name($data['author']['name'], $data['author']['surname'])
            )
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id->toString(),
            'title' => $this->title->getTitle(),
            'description' => $this->description->getDescription(),
            'content' => $this->content->getContent(),
            'author' => [
                'id' => $this->authorReadModel->getId(),
                'name' => $this->authorReadModel->getName()->getName(),
                'surname' => $this->authorReadModel->getName()->getSurname(),
            ]
        ];
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

    public function getAuthorReadModel(): AuthorReadModel
    {
        return $this->authorReadModel;
    }

}
