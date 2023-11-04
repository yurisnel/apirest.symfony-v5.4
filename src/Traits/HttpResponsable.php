<?php

namespace App\Traits;

use Doctrine\DBAL\Query\QueryException as QueryQueryException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Para crear respuestas HTTP estandarizadas con diferentes codigos
 */
trait HttpResponsable
{
    public function makeResponse($success, $message, $statusCode = Response::HTTP_OK, $error = null)
    {
        $response['success'] = $success;
        $response['message'] = $message;
        if ($error != null) {
            $response['error'] = $error;
        }
        return new JsonResponse($response, $statusCode);
    }

    public function makeResponseOK($data, $message = null)
    {
        $response['success'] = true;
        if ($this->checkMessage($message)) {
            $response['message'] = $message;
        }
        $response['data'] = $data;

        return new JsonResponse($response, Response::HTTP_OK);
    }

    public function makeResponseList($data, $links = null)
    {
        $response = ['success' => true, 'data' => $data, 'links' => $links];
        return new JsonResponse($response, Response::HTTP_OK);
    }

    public function makeResponseCreated($data, $message = null)
    {
        $response['success'] = true;
        $response['message'] = $this->checkMessage($message) ? $message : 'Recurso creado correctamente.';
        $response['data'] = $data;
        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    public function makeResponseUpdated($data, $message = null, $statusCode = Response::HTTP_OK)
    {
        $response['success'] =  true;
        $response['data'] = $data;
        $response['message'] = $this->checkMessage($message) ? $message : 'Recurso actualizado correctamente.';
        return new JsonResponse($response, $statusCode);
    }

    public function makeResponseNotFound($message = null)
    {
        $response['success'] = false;
        $response['data'] = null;
        $response['message'] = $message ;
        //$response['message'] = $this->checkMessage($message) ? $message : trans('msgs.msg_el_no_found', ['var' => trans_choice('msgs.label_account_reload', 1)]);
        return new JsonResponse($response, Response::HTTP_NOT_FOUND);

    }

    public function makeResponseUnprosesableEntity($message, $data = null)
    {
        $response['success'] = false;
        $response['data'] = $data;
        $response['message'] = $this->checkMessage($message) ? $message : 'The given data was invalid.';
        return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function makeResponseNoContent($message = null)
    {
        $response['message'] = $this->checkMessage($message) ? $message : "No hay recursos en lista";
        $response["success"] = true;
        $response["data"] = [];
        return new JsonResponse($response, Response::HTTP_NO_CONTENT);
    }

    public function makeResponseError($message = null, $data = array(), $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response["success"] = false;
        $response["message"] = $message;
        //$response["message"] = $this->checkMessage($message) ? $message : trans('msgs.msg_error_contact_the_adminitrator');
        $response["data"] = $data;
        return new JsonResponse($response, $statusCode);
    }

    public function makeResponseException(Throwable $e)
    {
        $response["success"] = false;
        $response["error"] = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
        //$response["message"] = trans('msgs.msg_error_contact_the_adminitrator');
        $response["message"] = 'msgs.msg_error_contact_the_adminitrator';
        return new JsonResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);       
    }

    public function makeResponseQueryException(QueryQueryException $e)
    {
        $response["success"] = false;
        $response["error"] = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
        //$response["message"] = trans('msgs.msg_error_filter_column_no_exist');
        $response["error"] = 'msg_error_filter_column_no_exist';
        return new JsonResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);  
    }

    protected function checkMessage($message)
    {
        if ($message != null) {
            return true;
        }
        return false;
    }
}
