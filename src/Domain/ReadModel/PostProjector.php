<?php

declare(strict_types=1);


namespace App\Domain\ReadModel;


use App\Domain\Event\PostWasCreatedEvent;
use App\Domain\Repository\AuthorWriteModelRepository;
use Broadway\ReadModel\Projector;

class PostProjector extends Projector
{
    private PostReadModelRepository $postReadModelRepository;
    private AuthorWriteModelRepository $authorWriteModelRepository;

    public function __construct(
        PostReadModelRepository $postReadModelRepository,
        AuthorWriteModelRepository $authorWriteModelRepository
    ) {
        $this->postReadModelRepository = $postReadModelRepository;
        $this->authorWriteModelRepository = $authorWriteModelRepository;
    }

    protected function applyPostWasCreatedEvent(PostWasCreatedEvent $event): void
    {
        $author = $this->authorWriteModelRepository->findOrFailById($event->getAuthorId());

        $post = new PostReadModel(
            $event->getId(),
            $event->getTitle(),
            $event->getDescription(),
            $event->getContent(),
            new AuthorReadModel($author->getId(), $author->getName())
        );

        $this->postReadModelRepository->save($post);
    }

}
