<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Application\Query\Dto;


use App\Application\Query\Dto\PostDto;
use App\Domain\ReadModel\AuthorReadModel;
use App\Domain\ReadModel\PostReadModel;
use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Name;
use App\Domain\VO\Title;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PostDtoTest extends TestCase
{
    /** @test */
    public function checkPostIsAssembleCorrectly()
    {
        $id = Uuid::uuid4();
        $name = new Name('Name', 'Surname');
        $title = new Title('Title');
        $description = new Description('Description');
        $content = new Content('Content');

        $postDto = new PostDto(
            $id->toString(),
            $title->getTitle(),
            $description->getDescription(),
            $content->getContent(),
            null
        );
        $authorReadModel = new AuthorReadModel($id, $name);
        $postReadModel = new PostReadModel($id, $title, $description, $content, $authorReadModel);

        $this->assertEquals($postDto, PostDto::assemble($postReadModel, false));
        $this->assertNull($postDto->getAuthor());
        $this->assertEquals($id->toString(), $postDto->getId());
        $this->assertEquals($title->getTitle(), $postDto->getTitle());
        $this->assertEquals($description->getDescription(), $postDto->getDescription());
        $this->assertEquals($content->getContent(), $postDto->getContent());
    }
}