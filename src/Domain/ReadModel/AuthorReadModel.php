<?php

declare(strict_types=1);


namespace App\Domain\ReadModel;


use App\Domain\VO\Name;
use Broadway\ReadModel\Identifiable;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AuthorReadModel implements Identifiable, Serializable
{
    private UuidInterface $id;
    private Name $name;

    public function __construct(UuidInterface $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    public function getId(): string
    {
        return $this->id->toString();
    }

    public static function deserialize(array $data)
    {
        return new self(
            Uuid::fromString($data['id']),
            new Name($data['name'], $data['surname'])
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name->getName(),
            'surname' => $this->name->getSurname()
        ];
    }

    public function getName(): Name
    {
        return $this->name;
    }

}
