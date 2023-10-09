<?php

namespace App\Http\Middleware;

use App\Traits\JWTResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class VerifyJwt extends BaseMiddleware
{
    use JWTResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $th) {
            if ($th instanceof TokenInvalidException) {
                return $this->handleTokenInvalidException();
            } else if ($th instanceof TokenExpiredException) {
                return $this->handleTokenExpiredException();
            } else {
                return $this->handleTokenNotFoundException();
            }
        }
        return $next($request);
    }
}
