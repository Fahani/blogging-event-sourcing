<?php

declare(strict_types=1);


namespace App\Infrastructure\Persistence\Broadway;


use App\Domain\Aggregate\Post;
use App\Domain\Exception\DomainEntityNotFoundException;
use App\Domain\Repository\PostWriteModelRepository;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;
use Ramsey\Uuid\UuidInterface;

class BroadwayPostWriteRepository extends EventSourcingRepository implements PostWriteModelRepository
{
    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        parent::__construct($eventStore, $eventBus, Post::class, new PublicConstructorAggregateFactory());
    }

    /**
     * @inheritDoc
     */
    public function findOrFailById(UuidInterface $id): Post
    {
        try{
            $post = $this->load($id);
        }
        catch (AggregateNotFoundException $e) {
            throw new DomainEntityNotFoundException("There isn't a post for this ID ($id)");
        }
        if (get_class($post) !== Post::class)
        {
            throw new DomainEntityNotFoundException("There isn't a post for this ID ($id)");
        }

        return $post;
    }
}
