<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Handle CSRF token mismatch (419 Page Expired)
        if ($exception instanceof TokenMismatchException) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Your session has expired. Please refresh the page and log in again.'], 419);
            } else {
                return redirect()->route('login')->with('message', 'Your session has expired. Please refresh the page and log in again.');
            }
        }

        return parent::render($request, $exception);
    }
}
