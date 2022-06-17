<?php

namespace App\Exceptions;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


  protected function unauthenticated($request, AuthenticationException $exception)
  {
    if ($request->expectsJson()) {
      return response()->json(['error' => 'unauthenticated']);
    }
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
      switch ($guard) {
        case 'user' :
          return redirect()->route('login');
          break;
        default:
          return redirect(RouteServiceProvider::LOGIN_PAGE_ERP);
      }
    }
  }
}
