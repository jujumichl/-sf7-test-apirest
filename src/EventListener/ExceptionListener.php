<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

// Pour avoir des exception en JSON et non en page HTML
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\JsonResponse;


final class ExceptionListener
{
    #[AsEventListener]
    public function onExceptionEvent(ExceptionEvent $event): void
    {
        // ...
        $exception = $event->getThrowable();

        if ($exception instanceof HttpException) {
            $data = [
                'message' => $exception->getMessage()
            ];
            $codeStatut = $exception->getStatusCode();
        } else {
            $data = [
                'message' => $exception->getMessage()
            ];
            $codeStatut = JsonResponse::HTTP_INTERNAL_SERVER_ERROR; // Le status n'existe pas car ce n'est pas une exception HTTP, donc on met 500 par défaut.
        }
        $event->setResponse(new JsonResponse($data, $codeStatut));

    }
}
