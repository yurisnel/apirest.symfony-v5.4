<?php

namespace App\Exceptions;

use App\Traits\HttpResponsable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;


class ExceptionListener
{
      use HttpResponsable;
      public function onKernelException(ExceptionEvent $event)
      {
            $exception = $event->getThrowable();        

            $response = $this->createApiResponse($exception);
            $event->setResponse($response);
      }

      private function createApiResponse(\Throwable $exception)
      {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $errors = [];
            if ($exception instanceof ExceptionCustom) {
                  $errors = $exception->getErrors();
                  $statusCode = $exception->getCode();
            }

            return $this->makeResponseError($exception->getMessage(), $errors, $statusCode);
      }
}
