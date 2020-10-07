<?php

declare(strict_types=1);


namespace App\Domain\Event;


use App\Domain\VO\Name;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AuthorWasCreatedEvent extends Event
{
    private UuidInterface $id;
    private Name $name;

    public function __construct(UuidInterface $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
        parent::__construct($id);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public static function deserialize(array $data): self
    {
        return new self(Uuid::fromString($data['id']), new Name($data['name']['name'], $data['name']['surname']));
    }

    public function specificSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' =>
                [
                    'name' => $this->name->getName(),
                    'surname' => $this->name->getSurname(),
                ]

        ];
    }
}
