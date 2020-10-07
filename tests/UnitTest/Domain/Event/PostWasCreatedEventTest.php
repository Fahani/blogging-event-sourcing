<?php

declare(strict_types=1);


namespace App\Tests\UnitTest\Domain\Event;


use App\Domain\Event\PostWasCreatedEvent;
use App\Domain\VO\Content;
use App\Domain\VO\Description;
use App\Domain\VO\Title;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PostWasCreatedEventTest extends TestCase
{

    /** @test */
    public function postWasCreatedEventSerializesAndDeserializes()
    {
        $id = Uuid::uuid4();
        $authorId = Uuid::uuid4();
        $title = new Title('Title');
        $description = new Description('Description');
        $content = new Content('Content');
        $postWasCreatedEvent = new PostWasCreatedEvent($id, $authorId, $title, $description, $content);

        $this->assertEquals($id, $postWasCreatedEvent->getId());
        $this->assertEquals($authorId, $postWasCreatedEvent->getAuthorId());
        $this->assertEquals($title, $postWasCreatedEvent->getTitle());
        $this->assertEquals($description, $postWasCreatedEvent->getDescription());
        $this->assertEquals($content, $postWasCreatedEvent->getContent());

        $postWasCreatedEventSerialized = [
            'id' => $id,
            'authorId' => $authorId,
            'title' => $title,
            'description' => $description,
            'content' => $content
        ];

        $postWasCreatedEventDeserialized = PostWasCreatedEvent::deserialize($postWasCreatedEventSerialized);

        $this->assertEquals($postWasCreatedEvent->getId(), $postWasCreatedEventDeserialized->getId());
        $this->assertEquals($postWasCreatedEvent->getAuthorId(), $postWasCreatedEventDeserialized->getAuthorId());
        $this->assertEquals($postWasCreatedEvent->getTitle(), $postWasCreatedEventDeserialized->getTitle());
        $this->assertEquals($postWasCreatedEvent->getDescription(), $postWasCreatedEventDeserialized->getDescription());
        $this->assertEquals($postWasCreatedEvent->getContent(), $postWasCreatedEventDeserialized->getContent());


        $postWasCreatedEventSpecificSerialized = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'authorId' => $authorId
        ];

        $this->assertEquals($postWasCreatedEventSpecificSerialized, $postWasCreatedEvent->specificSerialize());
    }



}