<?php

declare(strict_types=1);


namespace App\Domain\Event;


use Broadway\Serializer\Serializable;
use Ramsey\Uuid\UuidInterface;

abstract class Event implements Serializable
{
    private UuidInterface $id;


    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }


    abstract public static function deserialize(array $data);

    public function serialize(): array
    {
        return array_merge(['id' => $this->id], $this->specificSerialize());
    }

    abstract public function specificSerialize(): array;
}
