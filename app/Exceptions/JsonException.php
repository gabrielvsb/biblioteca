<?php

namespace App\Exceptions;

use Exception;

class JsonException extends Exception
{

    public function report()
    {
        //
    }


    public function render($request)
    {
        return response()->json();
    }
}
