<?php

declare(strict_types=1);


namespace App\Infrastructure\Ui\Http\Rest\EventListener;


use App\Domain\Exception\DomainException;
use JsonException;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!empty($event->getRequest()->getContent())) {
            $contentType = $event->getRequest()->headers->get('content-type');
            if ($contentType === 'application/xml') {
                try {
                    $event->getRequest()->request->add(
                        json_decode(
                            json_encode(
                                simplexml_load_string(
                                    $event->getRequest()->getContent()
                                ), JSON_THROW_ON_ERROR
                            ), true, 512, JSON_THROW_ON_ERROR
                        )
                    );

                } catch (JsonException $e) {
                    throw new DomainException('Invalid Params');
                }

            } elseif ($contentType === 'application/json') {
                try {
                    $event->getRequest()->request->add(
                        json_decode($event->getRequest()->getContent(), true, 512, JSON_THROW_ON_ERROR)
                    );
                } catch (JsonException $e) {
                    throw new DomainException('Invalid Params');
                }
            }
        }
    }
}
