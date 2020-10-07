<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Application\Command\SavePost;


use App\Application\Command\SavePost\SavePostCommand;
use App\Application\Command\SavePost\SavePostCommandHandler;
use App\Domain\Aggregate\Post;
use App\Domain\Event\PostWasCreatedEvent;
use App\Domain\Exception\DomainDuplicateEntityException;
use App\Domain\Repository\PostWriteModelRepository;
use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Title;
use Broadway\Domain\DomainEventStream;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\EventStore\Exception\DuplicatePlayheadException;
use Ramsey\Uuid\Uuid;

class SavePostCommandTest extends AggregateRootScenarioTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }


    /**
     * @test
     */
    public function itShouldSaveAPost(): void
    {
        $id = Uuid::uuid4();
        $authorId = Uuid::uuid4();
        $title = new Title('title');
        $description = new Description('description');
        $content = new Content('content');

        $postRepository = $this->createMock(PostWriteModelRepository::class);

        $post = Post::create(
            $id,
            $authorId,
            $title,
            $description,
            $content
        );

        $postRepository
            ->expects(self::once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Post $post) use ($id) {
                        return $post->getId()->equals($id);
                    }
                )
            );

        $commandHandler = new SavePostCommandHandler($postRepository);
        $commandHandler->__invoke(
            new SavePostCommand(
                $id->toString(),
                $title->getTitle(),
                $description->getDescription(),
                $content->getContent(),
                $authorId->toString()
            )
        );

        $this->scenario
            ->when(
                function () use ($post) {
                    return $post;
                }
            )
            ->then(
                [
                    new PostWasCreatedEvent(
                        $id,
                        $authorId,
                        $title,
                        $description,
                        $content
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
        $authorId = Uuid::uuid4();
        $title = new Title('title');
        $description = new Description('description');
        $content = new Content('content');


        $postWriteModelRepository = $this->createMock(PostWriteModelRepository::class);
        $postWriteModelRepository
            ->expects(self::once())
            ->method('save')
            ->will(
                self::throwException(
                    new DuplicatePlayheadException(
                        new DomainEventStream([])
                    )
                )
            );

        $commandHandler = new SavePostCommandHandler($postWriteModelRepository);
        $commandHandler->__invoke(
            new SavePostCommand(
                $id->toString(),
                $title->getTitle(),
                $description->getDescription(),
                $content->getContent(),
                $authorId->toString()
            )
        );

    }

    protected function getAggregateRootClass(): string
    {
        return Post::class;
    }
}
