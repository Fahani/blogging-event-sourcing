<?php

declare(strict_types=1);


namespace App\Application\Query\Dto;


use App\Domain\ReadModel\PostReadModel;

final class PostDto
{
    private string $id;
    private string $title;
    private string $description;
    private string $content;
    private ?AuthorDto $author;

    public function __construct(string $id, string $title, string $description, string $content, ?AuthorDto $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->author = $author;
    }

    public static function assemble(PostReadModel $post, bool $includeAuthor): PostDto
    {
        return new self(
            $post->getId(),
            $post->getTitle()->getTitle(),
            $post->getDescription()->getDescription(),
            $post->getContent()->getContent(),
            $includeAuthor ? AuthorDto::assemble($post->getAuthorReadModel()) : null
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): ?AuthorDto
    {
        return $this->author;
    }


}
