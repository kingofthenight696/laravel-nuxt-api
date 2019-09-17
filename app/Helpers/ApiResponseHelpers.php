<?php

namespace App\Helpers;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;


class ApiResponseHelpers
{
    public const RESPONSE_STATUS_SUCCESS = 'Success';
    public const RESPONSE_MSG_SUCCESS = 'Success';
    public const RESPONSE_STATUS_ERROR = 'Error';
    public const RESPONSE_STATUS_UNAUTHORIZED = 'Unauthorized';
    public const RESPONSE_MSG_UNAUTHORIZED = 'Unauthorized';
    public const RESPONSE_STATUS_INTERNAL_ERROR = 'Internal Server Error';
    public const RESPONSE_MSG_INTERNAL_ERROR = 'Internal Server Error';
    public const RESPONSE_STATUS_FORBIDDEN = 'Forbidden';
    public const RESPONSE_MSG_FORBIDDEN = 'Access denied';
    public const RESPONSE_NOT_FOUND_STATUS = 'Not Found';
    public const RESPONSE_NOT_FOUND_MSG = 'Not Found';


    public static function successApiResponse($data = [], $message = null, $code = 200)
    {
        $message = $message ?? self::RESPONSE_MSG_SUCCESS;

        $responseData = [
            'request_status' => self::RESPONSE_STATUS_SUCCESS,
            'message' => $message
        ];

        //if ($data) {
        $responseData['data'] = $data;
        //}

        try {
            return response()->json($responseData, $code);
        } catch (Exception $e) {
            // Probably something is wrong with encoding
            $fixedData = self::convertToUtf8Recursively($responseData);
            return response()->json($fixedData, $code);
        }
    }

    // see https://stackoverflow.com/a/38398648/1295902
    protected static function convertToUtf8Recursively($data)
    {
        if (is_string($data)) {
            return utf8_encode($data);
        }

        if (is_array($data)) {
            $ret = [];
            foreach ($data as $i => $d) {
                $ret[$i] = self::convertToUtf8Recursively($d);
            }

            return $ret;
        }

        if (is_object($data)) {
            foreach ($data as $i => $d) {
                $data->$i = self::convertToUtf8Recursively($d);
            }

            return $data;
        }

        return $data;
    }

    public static function unauthorizedApiResponse($errors = [], $message = null, $code = 401)
    {
        $message = $message ?? self::RESPONSE_MSG_UNAUTHORIZED;

        $responseData = [
            'request_status' => self::RESPONSE_STATUS_UNAUTHORIZED,
            'message' => $message,
            'errors' => $errors
        ];

        return response()->json($responseData, $code);
    }

    public static function internalErrorApiResponse($errors = [], $message = null, $code = 500)
    {
        $message = $message ?? self::RESPONSE_MSG_INTERNAL_ERROR;

        $responseData = [
            'request_status' => self::RESPONSE_STATUS_INTERNAL_ERROR,
            'message' => $message,
            'errors' => $errors
        ];

        return response()->json($responseData, $code);
    }

    public static function assessDenied($message = null, $code = 403)
    {
        $message = $message ?? self::RESPONSE_MSG_FORBIDDEN;

        $responseData = [
            'request_status' => self::RESPONSE_STATUS_FORBIDDEN,
            'message' => $message
        ];

        return response()->json($responseData, $code);
    }

    public static function resourceNotFound($message = null, $code = 404)
    {
        $message = $message ?? self::RESPONSE_NOT_FOUND_STATUS;


        $responseData = [
            'request_status' => self::RESPONSE_NOT_FOUND_MSG,
            'message' => $message
        ];

        return response()->json($responseData, $code);
    }

    public static function paginateResponse(Paginator $pagination)
    {
        $data = [
            'items' => $pagination->items(),
            'pagination' => [
                'per_page' => $pagination->perPage(),
                'page' => $pagination->currentPage(),
                'has_more' => $pagination->hasMorePages(),
                'total' => $pagination->total()
            ],
        ];

        return self::successApiResponse($data);
    }
}
