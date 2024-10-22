<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\TelegramHelper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use TelegramHelper;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        //     $msgFormat  = "Error Found [WASP] %0A ";
        //     $msgFormat .= "File: {$e->getFile()} %0A ";
        //     $msgFormat .= "Line: {$e->getLine()} %0A ";
        //     $msgFormat .= "Message:  %0A{$e->getMessage()} %0A ";

        //     $this->telegramSendMessage("2021159313:AAHEBoOLogYjLCpSwVeKPVmKKO4TIxa02vQ","-949707668",$msgFormat);
        // });   
    }
}
