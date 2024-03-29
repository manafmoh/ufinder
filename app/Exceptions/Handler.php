<?php

namespace App\Exceptions;

use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
         if($exception instanceof TokenBlacklistedException) {
            return response(['error'=> 'Token is not used, get new one'], Response::HTTP_BAD_REQUEST);
         } else if($exception instanceof TokenInvalidException) {
            return response(['error'=> 'Token is invalid'], Response::HTTP_BAD_REQUEST);
         } else if($exception instanceof TokenExpiredException) {
            return response(['error'=> 'Token is expired'], Response::HTTP_BAD_REQUEST);
         } else if($exception instanceof JWTException) {
            return response(['error'=> 'Token not Provided'], Response::HTTP_BAD_REQUEST);
         }
        return parent::render($request, $exception);
    }
}
