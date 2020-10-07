<?php

declare(strict_types=1);


namespace App\Tests\UniTest\Application\Query\FindPostById;

use App\Application\Query\FindPostById\FindPostByIdQuery;
use App\Application\Query\FindPostById\FindPostByIdQueryHandler;
use App\Domain\ReadModel\AuthorReadModel;
use App\Domain\ReadModel\PostReadModel;
use App\Domain\ReadModel\PostReadModelRepository;
use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Name;
use App\Domain\VO\Title;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FindPostByIdQueryHandlerTest extends TestCase
{

    /**
     * @test
     */
    public function itShouldReturnAPost(): void
    {
        $authorId = Uuid::uuid4();
        $name = new Name(
            'nico',
            'gonzalez'
        );

        $authorReadModel = new AuthorReadModel(
            $authorId,
            $name
        );

        $id = Uuid::uuid4();

        $title = new Title('title');
        $description = new Description('description');
        $content = new Content('content');

        $postReadModel = new PostReadModel(
            $id,
            $title,
            $description,
            $content,
            $authorReadModel
        );

        $postReadModelRepository = $this->createMock(PostReadModelRepository::class);
        $postReadModelRepository
            ->expects(self::once())
            ->method('findOrFailById')
            ->willReturn($postReadModel);


        $findPostByIdQueryHandler = new FindPostByIdQueryHandler($postReadModelRepository);
        $postDto = $findPostByIdQueryHandler->__invoke(
            new FindPostByIdQuery(
                $id->toString(),
                false
            )
        );
        self::assertEquals($id->toString(), $postDto->getId());
    }

}
