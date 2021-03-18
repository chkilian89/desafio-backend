<?php

namespace App\Traits;

use Throwable;

trait JsonExceptionTrait
{
    public static function jsonException(Throwable $exception)
    {
        return json_encode([
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace()
        ]);
    }
}
