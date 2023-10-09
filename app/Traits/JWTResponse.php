<?php

namespace App\Traits;

use Illuminate\Http\Response;


class Errors
{
    public $name, $message;
    /**
     * Class constructor.
     */
    public function __construct($name, $message)
    {
        $this->name = $name;
        $this->message = $message;
    }
}


trait JWTResponse
{

    /**
     * Handle Token Invalid Exception
     *
     * Handles the Token Invalid Exception and returns a JSON response with the status status of 401 Unauthorized.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleTokenInvalidException()
    {
        $error = new Errors('TokenNotValid', 'token must be valid');
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Unauthorized',
            'errors' => $error
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Handle Token Expired Exception
     *
     * Handles the Token Expired Exception and returns a JSON response with the status status of 401 Unauthorized.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleTokenExpiredException()
    {
        $error = new Errors('TokenExpired', 'token expired');
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Token expired',
            'errors' => $error
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Handle Token Not Found
     *
     * Handles the Token Not Found Exception and returns a JSON response with the status status of 401 Unauthorized.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleTokenNotFoundException()
    {
        $error = new Errors('TokenNotFound', 'token must be provided');
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Failed!',
            'errors' => $error
        ], Response::HTTP_UNAUTHORIZED);
    }
    public function handleTokenBlacklList()
    {
        $error = new Errors('TokenBlackList', 'The token has been blacklisted');
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Failed!',
            'errors' => $error
        ], Response::HTTP_UNAUTHORIZED);
    }
}
