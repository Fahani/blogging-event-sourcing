<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Domain\VO;


use App\Domain\VO\Description;
use PHPUnit\Framework\TestCase;

class DescriptionTest extends TestCase
{

    /**
     * @test
     */
    public function valueObjectDescriptionCreatedCorrectly(): void {
        $descriptionVo = new Description('Description');
        $this->assertEquals('Description', $descriptionVo->getDescription());
    }
}
