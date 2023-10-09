<?php

namespace App\Traits;

use Illuminate\Http\Response;

/**
 * API RESPONSE 
 */
trait ResponseAPI
{
    public static function requestSuccessData($data,  $status = 200, $message = "Success!")
    {
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $data,
        ]);
    }
    public static function requestSuccessWithLog($log, $message = 'Success!')
    {
        return response()->json([
            "status" => Response::HTTP_OK,
            "message" => $message,
            "log" => $log
        ], Response::HTTP_OK);
    }
    public static function requestSuccess($message = 'Success!', $code = 200)
    {
        return response()->json([
            "status" => $code,
            "message" => $message,
        ], $code);
    }
    public static function loginSuccess($dataUser, $token)
    {
        return response()->json([
            "status" => Response::HTTP_OK,
            "message" => "Success!",
            "token" => $token,
            "data" => $dataUser
        ]);
    }
    public static function requestRefreshToken($token)
    {
        return response()->json([
            "status" => Response::HTTP_OK,
            "message" => "Success!",
            "token" => $token,
        ]);
    }
    public static function badRequest($error = 'bad_request', $message = 'bad_request')
    {
        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "message" => $message,
            "errors" => $error
        ], Response::HTTP_BAD_REQUEST);
    }
    public static function requestUnauthorized($message, $errors = 'Unauthorized')
    {
        return response()->json([
            "status" =>  Response::HTTP_UNAUTHORIZED,
            "message" => $message,
            "errors" => $errors,
        ], Response::HTTP_UNAUTHORIZED);
    }
    public static function requestNotFound($message)
    {
        return response()->json([
            "status" => Response::HTTP_NOT_FOUND,
            "message" => $message,
        ], Response::HTTP_NOT_FOUND);
    }
    public static function requestValidation($errors = [], $message = 'Failed!')
    {
        return response()->json([
            "status" => Response::HTTP_BAD_REQUEST,
            "message" => $message,
            "errors" => $errors
        ], Response::HTTP_BAD_REQUEST);
    }
}
