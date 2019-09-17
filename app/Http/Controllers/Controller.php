<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Exceptions\IncorrectDataException;
use App\Helpers\ApiResponseHelpers;
use App\Helpers\LogHelper;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected const DEFAULT_SUCCESS_CODE = 200;
    protected const DEFAULT_ERROR_CODE = 500;

    protected const SERVICE_EXCEPTIONS = [
        GeneralException::class,
        IncorrectDataException::class
    ];

    protected function successApiResponse($message = null, $data = [], $code = self::DEFAULT_SUCCESS_CODE)
    {
        if (!is_numeric($code) || $code < 200 || $code > 399) {
            $code = self::DEFAULT_SUCCESS_CODE;
        }
        return ApiResponseHelpers::successApiResponse($data, $message, $code);
    }

    protected function errorApiResponse($message = null, $errors = [], $code = self::DEFAULT_ERROR_CODE)
    {
        if (is_a($message, Exception::class)) {
            return $this->errorApiByException($message, null, $code);
        }
        if (!is_numeric($code) || $code < 400) {
            $code = self::DEFAULT_ERROR_CODE;
        }
        return ApiResponseHelpers::internalErrorApiResponse($errors, $message, $code);
    }

    protected function errorApiByException(Exception $e, $returnMessageForPhpException = null, $errorCode = self::DEFAULT_ERROR_CODE)
    {

        if (in_array(get_class($e), self::SERVICE_EXCEPTIONS, true)) {
            $returnMessageForPhpException = $e->getMessage();
        } else {

            if ($returnMessageForPhpException === null) {
                $returnMessageForPhpException = $e->getMessage();
            }

            LogHelper::storeException($e, LogHelper::LEVEL_ERROR);
        }

        return $this->errorApiResponse($returnMessageForPhpException, [], $errorCode);
    }
}
