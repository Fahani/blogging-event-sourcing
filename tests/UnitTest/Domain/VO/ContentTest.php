<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Domain\VO;


use App\Domain\VO\Content;
use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{

    /**
     * @test
     */
    public function valueObjectContentCreatedCorrectly(): void {
        $contentVo = new Content('Content');
        $this->assertEquals('Content', $contentVo->getContent());
    }
}
