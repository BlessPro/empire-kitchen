<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;

class Handler extends Exception
{
    //when user session expires
//     protected function unauthenticated($request, AuthenticationException $exception)
// {
//     return redirect()->guest(route('login'));
// }

protected function unauthenticated($request, AuthenticationException $exception)
{
    if ($request->expectsJson()) {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    return redirect()->guest(route('login'));
}


}
