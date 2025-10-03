<?php

namespace Src\App\Exceptions;

use Src\App\Controllers\FileComposerController;
use Exception;
use Throwable;

class NotFoundException extends Exception{

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null){

        parent::__construct($message, $code, $previous);
    }

    public function error404(string $error){
        FileComposerController::error404($error);
    }
}