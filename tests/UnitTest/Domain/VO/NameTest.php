<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Domain\VO;


use App\Domain\VO\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{

    /**
     * @test
     */
    public function valueObjectNameCreatedCorrectly(): void {
        $nameVo = new Name('Name', 'Surname');
        $this->assertEquals('Name', $nameVo->getName());
        $this->assertEquals('Surname', $nameVo->getSurname());
    }
}
