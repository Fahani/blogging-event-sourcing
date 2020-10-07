<?php

declare(strict_types=1);


namespace App\Application\Query\FindPostById;

use App\Application\Query\Dto\PostDto;
use App\Domain\ReadModel\PostReadModelRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FindPostByIdQueryHandler implements MessageHandlerInterface
{
    private PostReadModelRepository $postRepository;

    public function __construct(PostReadModelRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(FindPostByIdQuery $query): PostDto
    {
        return PostDto::assemble(
            $this->postRepository->findOrFailById(Uuid::fromString($query->getId())),
            $query->isIncludeAuthor()
        );
    }
}
