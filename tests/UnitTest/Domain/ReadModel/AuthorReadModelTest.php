<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Domain\ReadModel;


use App\Domain\ReadModel\AuthorReadModel;
use App\Domain\VO\Name;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AuthorReadModelTest extends TestCase
{
    /** @test */
    public function authorReadModelSerializesAndDeserializeCorrectly(): void
    {
        $id = Uuid::uuid4();
        $name = new Name('Name', 'Surname');
        $authorReadModel = new AuthorReadModel($id, $name);

        $this->assertEquals($name, $authorReadModel->getName());
        $this->assertEquals($id, $authorReadModel->getId());

        $authorReadModelSerialized = [
            'id' => $id->toString(),
            'name' => $name->getName(),
            'surname' => $name->getSurname()
        ];

        $this->assertEquals($authorReadModel, AuthorReadModel::deserialize($authorReadModelSerialized));
        $this->assertEquals($authorReadModelSerialized, $authorReadModel->serialize());

    }
}
