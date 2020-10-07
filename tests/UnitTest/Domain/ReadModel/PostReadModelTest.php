<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Domain\ReadModel;


use App\Domain\ReadModel\AuthorReadModel;
use App\Domain\ReadModel\PostReadModel;
use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Name;
use App\Domain\VO\Title;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PostReadModelTest extends TestCase
{

    /** @test */
    public function postReadModelSerializesAndDeserializesCorrectly()
    {
        $id = Uuid::uuid4();
        $title = new Title('Title');
        $description = new Description('Description');
        $content = new Content('Content');
        $authorId = Uuid::uuid4();
        $name = new Name('Name', 'Surname');
        $authorReadModel = new AuthorReadModel($authorId, $name);
        $postReadModel = new PostReadModel($id, $title, $description, $content, $authorReadModel);

        $this->assertEquals($id, $postReadModel->getId());
        $this->assertEquals($title, $postReadModel->getTitle());
        $this->assertEquals($description, $postReadModel->getDescription());
        $this->assertEquals($content, $postReadModel->getContent());
        $this->assertEquals($authorReadModel, $postReadModel->getAuthorReadModel());

        $postReadModelSerialized = [
            'id' => $id->toString(),
            'title' => $title->getTitle(),
            'description' => $description->getDescription(),
            'content' => $content->getContent(),
            'author' => [
                'id' => $authorId->toString(),
                'name' => $name->getName(),
                'surname' => $name->getSurname()
            ]
        ];

        $this->assertEquals($postReadModel, PostReadModel::deserialize($postReadModelSerialized));
        $this->assertEquals($postReadModelSerialized, $postReadModel->serialize());
    }
}