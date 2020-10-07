<?php

declare(strict_types=1);


namespace App\Infrastructure\Ui\Http\Rest\EventListener;


use App\Domain\Exception\DomainDuplicateEntityException;
use App\Domain\Exception\DomainEntityNotFoundException;
use App\Domain\Exception\DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof DomainEntityNotFoundException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'exception' => get_class($exception),
                        'exceptionMessage' => $exception->getMessage(),
                        'exceptionTrace' => $exception->getTraceAsString()
                    ],
                    Response::HTTP_NOT_FOUND
                )
            );
        } elseif ($exception instanceof DomainException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'exception' => get_class($exception),
                        'exceptionMessage' => $exception->getMessage(),
                        'exceptionTrace' => $exception->getTraceAsString()
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        } elseif ($exception instanceof DomainDuplicateEntityException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'exception' => get_class($exception),
                        'exceptionMessage' => $exception->getMessage(),
                        'exceptionTrace' => $exception->getTraceAsString()
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }

    }
}
