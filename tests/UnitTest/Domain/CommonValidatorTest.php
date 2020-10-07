<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Domain;


use App\Domain\CommonValidator;
use App\Domain\Exception\DomainException;
use PHPUnit\Framework\TestCase;

class CommonValidatorTest extends TestCase
{
    /** @test */
    public function throwsDomainException(){
        $this->expectException(DomainException::class);
        CommonValidator::validateNotEmptyString('','Invalid String');
    }
}