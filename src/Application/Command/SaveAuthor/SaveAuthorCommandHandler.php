<?php

declare(strict_types=1);


namespace App\Application\Command\SaveAuthor;


use App\Domain\Aggregate\Author;
use App\Domain\Exception\DomainDuplicateEntityException;
use App\Domain\Repository\AuthorWriteModelRepository;
use App\Domain\VO\Name;
use Broadway\EventStore\Exception\DuplicatePlayheadException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SaveAuthorCommandHandler implements MessageHandlerInterface
{

    private AuthorWriteModelRepository $authorRepository;

    public function __construct(AuthorWriteModelRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function __invoke(SaveAuthorCommand $saveAuthorCommand)
    {
        $author = Author::create(
            Uuid::fromString($saveAuthorCommand->getAuthorId()),
            new Name($saveAuthorCommand->getAuthorName(), $saveAuthorCommand->getAuthorSurname())
        );

        try {
            $this->authorRepository->save($author);

        } catch (DuplicatePlayheadException $e) {
            throw new DomainDuplicateEntityException("Duplicated entity" . $e->getMessage());
        }
    }
}
