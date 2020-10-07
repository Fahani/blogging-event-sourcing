<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Domain\VO;


use App\Domain\VO\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{

    /**
     * @test
     */
    public function valueObjectTitleCreatedCorrectly(): void {
        $titleVo = new Title('Title');
        $this->assertEquals('Title', $titleVo->getTitle());
    }
}
