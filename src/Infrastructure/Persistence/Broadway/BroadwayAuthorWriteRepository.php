<?php

declare(strict_types=1);


namespace App\Infrastructure\Persistence\Broadway;


use App\Domain\Aggregate\Author;
use App\Domain\Exception\DomainEntityNotFoundException;
use App\Domain\Repository\AuthorWriteModelRepository;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;
use Ramsey\Uuid\UuidInterface;

class BroadwayAuthorWriteRepository extends EventSourcingRepository implements AuthorWriteModelRepository
{
    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        parent::__construct($eventStore, $eventBus, Author::class, new PublicConstructorAggregateFactory());
    }


    /**
     * @inheritDoc
     */
    public function findOrFailById(UuidInterface $id): Author
    {
        try{
            $author = $this->load($id);
        }
        catch (AggregateNotFoundException $e) {
            throw new DomainEntityNotFoundException("There isn't an author for this ID ($id)");
        }
        if (get_class($author) !== Author::class)
        {
            throw new DomainEntityNotFoundException("There isn't a post for this ID ($id)");
        }

        return $author;
    }
}
