<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Application\Query\Dto;


use App\Application\Query\Dto\AuthorDto;
use App\Domain\ReadModel\AuthorReadModel;
use App\Domain\VO\Name;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AuthorDtoTest extends TestCase
{
    /** @test */
    public function authorDtoIsAssembleCorrectly(): void
    {
        $id = Uuid::uuid4();
        $name = new Name('Name', 'Surname');
        $authorDto = new AuthorDto($id->toString(), $name->getName(), $name->getSurname());
        $authorReadModel = new AuthorReadModel($id, $name);
        $this->assertEquals($authorDto, AuthorDto::assemble($authorReadModel));
        $this->assertEquals($id->toString(), $authorDto->getId());
        $this->assertEquals($name->getName(), $authorDto->getName());
        $this->assertEquals($name->getSurname(), $authorDto->getSurname());
    }
}
