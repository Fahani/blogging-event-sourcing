<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Application\Command\SaveAuthor;


use App\Application\Command\SaveAuthor\SaveAuthorCommand;
use App\Application\Command\SaveAuthor\SaveAuthorCommandHandler;
use App\Domain\Aggregate\Author;
use App\Domain\Event\AuthorWasCreatedEvent;
use App\Domain\Exception\DomainDuplicateEntityException;
use App\Domain\Repository\AuthorWriteModelRepository;
use App\Domain\VO\Name;
use Broadway\Domain\DomainEventStream;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\EventStore\Exception\DuplicatePlayheadException;
use Ramsey\Uuid\Uuid;

class SaveAuthorCommandTest extends AggregateRootScenarioTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }


    /**
     * @test
     */
    public function itShouldSaveAnAuthor(): void
    {
        $id = Uuid::uuid4();
        $name = new Name(
            'nico',
            'gonzalez'
        );

        $authorWriteModelRepository = $this->createMock(AuthorWriteModelRepository::class);

        $author = Author::create(
            $id,
            $name
        );

        $authorWriteModelRepository
            ->expects(self::once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Author $author) use ($id) {
                        return $author->getId()->equals($id);
                    }
                )
            );

        $commandHandler = new SaveAuthorCommandHandler($authorWriteModelRepository);
        $commandHandler->__invoke(
            new SaveAuthorCommand(
                $id->serialize(),
                $name->getName(),
                $name->getSurname()
            )
        );

        $this->scenario
            ->when(
                function () use ($author) {
                    return $author;
                }
            )
            ->then(
                [
                    new AuthorWasCreatedEvent(
                        $id,
                        $name
                    )
                ]
            );

    }

    /**
     * @test
     */
    public function itShouldThrownDomainDuplicateEntityException(): void
    {
        $this->expectException(DomainDuplicateEntityException::class);

        $id = Uuid::uuid4();
        $name = new Name(
            'nico',
            'gonzalez'
        );

        $authorWriteModelRepository = $this->createMock(AuthorWriteModelRepository::class);
        $authorWriteModelRepository
            ->expects(self::once())
            ->method('save')
            ->will(
                self::throwException(
                    new DuplicatePlayheadException(
                        new DomainEventStream([])
                    )
                )
            );

        $commandHandler = new SaveAuthorCommandHandler($authorWriteModelRepository);
        $commandHandler->__invoke(
            new SaveAuthorCommand(
                $id->serialize(),
                $name->getName(),
                $name->getSurname()
            )
        );

    }

    protected function getAggregateRootClass(): string
    {
        return Author::class;
    }
}
