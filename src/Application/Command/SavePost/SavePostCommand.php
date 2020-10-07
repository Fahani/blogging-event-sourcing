<?php

declare(strict_types=1);


namespace App\Application\Command\SavePost;


class SavePostCommand
{
    private string $postId;
    private string $postTitle;
    private string $postDescription;
    private string $postContent;
    private string $authorId;


    public function __construct(
        string $postId,
        string $postTitle,
        string $postDescription,
        string $postContent,
        string $authorId
    ) {
        $this->postId = $postId;
        $this->postTitle = $postTitle;
        $this->postDescription = $postDescription;
        $this->postContent = $postContent;
        $this->authorId = $authorId;
    }


    public function getPostId(): string
    {
        return $this->postId;
    }

    public function getPostTitle(): string
    {
        return $this->postTitle;
    }

    public function getPostDescription(): string
    {
        return $this->postDescription;
    }

    public function getPostContent(): string
    {
        return $this->postContent;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }
}
