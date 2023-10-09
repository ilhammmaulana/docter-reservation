<?php

namespace App\Http\Middleware;

use App\Traits\JWTResponse;
use App\Traits\ResponseAPI;
use Closure;
use Illuminate\Http\Request;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class VerifyRefreshToken extends BaseMiddleware
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
            } else if ($th instanceof TokenBlacklistedException) {
                return $this->handleTokenBlacklList();
            } else if ($th instanceof TokenExpiredException) {
                return $next($request);
            } else {
                return $this->handleTokenNotFoundException();
            }
        }
        return $next($request);
    }
}
