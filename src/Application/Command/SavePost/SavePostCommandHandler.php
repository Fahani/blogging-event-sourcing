<?php

declare(strict_types=1);


namespace App\Application\Command\SavePost;


use App\Domain\Aggregate\Post;
use App\Domain\Exception\DomainDuplicateEntityException;
use App\Domain\Repository\PostWriteModelRepository;
use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Title;
use Broadway\EventStore\Exception\DuplicatePlayheadException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SavePostCommandHandler implements MessageHandlerInterface
{

    private PostWriteModelRepository $postRepository;

    public function __construct(PostWriteModelRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(SavePostCommand $savePostCommand)
    {
        $post = Post::create(
            Uuid::fromString($savePostCommand->getPostId()),
            Uuid::fromString($savePostCommand->getAuthorId()),
            new Title($savePostCommand->getPostTitle()),
            new Description($savePostCommand->getPostDescription()),
            new Content($savePostCommand->getPostContent())
        );


        try {
            $this->postRepository->save($post);
        } catch (DuplicatePlayheadException $e) {
            throw new DomainDuplicateEntityException("Duplicated entity" . $e->getMessage());
        }
    }
}
