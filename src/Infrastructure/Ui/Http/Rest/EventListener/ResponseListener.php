<?php

declare(strict_types=1);


namespace App\Infrastructure\Ui\Http\Rest\EventListener;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ResponseListener
{
    private Serializer $serializer;


    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }


    public function onKernelResponse(ResponseEvent $event): void
    {
        $contentType = $event->getRequest()->headers->get('Content-Type');

        if ($contentType === 'application/xml') {
            $contentType = 'xml';
        } elseif ($contentType === 'application/json') {
            $contentType = 'json';
        }

        if (($contentType === 'xml' || $contentType === 'json') && !empty($event->getResponse()->getContent()) && $event->getResponse()->getStatusCode() !== 500) {
            $object = unserialize($event->getResponse()->getContent());
            $event->setResponse(
                new Response(
                    $this->serializer->serialize(
                        $object, $contentType,
                        [ObjectNormalizer::SKIP_NULL_VALUES => true]
                    ),
                    $event->getResponse()->getStatusCode()
                )
            );
        }
    }
}
