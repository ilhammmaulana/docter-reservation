<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegiesterRequest;
use App\Http\Requests\API\UpdatePasswordRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\JWTResponse;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Storage;

class AuthController extends ApiController
{
    use ResponseAPI, JWTResponse;
    public function __construct()
    {
        $this->middleware('auth.api', ['except' => ['login', 'refresh', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginRequest)
    {
        $loginType = filter_var($loginRequest->input('email_or_phone'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if ($loginType == 'phone') {
            $phoneNumber = $loginRequest->input('email_or_phone');
            if (!ctype_digit($phoneNumber)) {
                return $this->badRequest('bad_request', 'Failed! Invalid email  or phone', 'invalid_value');
            }
        }
        $loginRequest->merge([
            $loginType => $loginRequest->input('email_or_phone')
        ]);
        $credentials = $loginRequest->only($loginType, 'password');
        $expiresIn = $loginRequest->input('expires_in') ?: config('jwt.ttl');
        if (!$token = $this->guard()->setTTL($expiresIn)->attempt($credentials)) {
            return $this->requestUnauthorized('Login Failed! ,Email or phone number and password is incorrect');
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function me()
    {
        return $this->requestSuccessData(new UserResource($this->guard()->user()));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        return $this->requestSuccess('Success Logout!');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $expiresIn = (int)request('expires_in') ?: config('jwt.ttl');
        try {
            return $this->requestRefreshToken($this->guard()->setTTL($expiresIn)->refresh());
        } catch (\Throwable $th) {
            return $this->handleTokenBlacklList();
        }
    }
    public function updatePassword(UpdatePasswordRequest $updatePasswordRequest)
    {
        $input = $updatePasswordRequest->only('new_password', 'old_password', 'password_confirmation');
        $credentials = [
            "email" => $this->guard()->user()->email,
            "password" => $input['old_password']
        ];
        if (!$this->guard()->attempt($credentials)) {
            return $this->requestUnauthorized('Failed!, Old password wrong');
        }
        $newPassword = bcrypt($input['new_password']);
        User::find($this->guard()->id())->update([
            "password" => $newPassword
        ]);
        return $this->requestSuccess('Success!');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->loginSuccess(new UserResource($this->guard()->user()), $token);
    }
    public function register(RegiesterRequest $regiesterRequest)
    {
        $input = $regiesterRequest->only('name', 'email', 'phone', 'password', 'confirm_password');
        if (empty($input['email']) && empty($input['phone'])) {
            return $this->badRequest('error_validation'); //penting jangan dirubah
        }
        $input['password'] = bcrypt($input['password']);
        unset($input['confirm_password']);
        try {
            User::create($input);
            return $this->requestSuccess('Register Success!', 201);
        } catch (\Illuminate\Database\QueryException $errors) {
            if ($errors->errorInfo[1] === 1062) {
                if (strpos($errors->getMessage(), 'users_email_unique') !== false) {
                    return $this->badRequest('email_unique', 'Email already registered!');
                } elseif (strpos($errors->getMessage(), 'users_phone_unique') !== false) {
                    return $this->badRequest('phone_unique', 'Phone number already registered!');
                }
            } else {
                return $this->badRequest($errors->getMessage());
            }
        } catch (\Throwable $errors) {
            return $this->badRequest('bad_request');
        }
    }

    public function update(UpdateProfileRequest $updateProfileRequest)
    {
        try {
            $photo = $updateProfileRequest->file('photo');
            $input = $updateProfileRequest->only('name');
            $user = User::find($this->guard()->id());
            if ($photo) {
                $pathDelete = $user->photo;
                if ($pathDelete !== null) {
                    Storage::delete($pathDelete);
                }
                $path = Storage::disk('public')->put('images/users', $photo);
                $user->photo = 'public/' . $path;
            }
            $user->name = $input['name'];
            $user->save();
            return $this->requestSuccessData(new UserResource($user));
        } catch (\Illuminate\Database\QueryException $errors) {
            if ($errors->errorInfo[1] === 1062) {
                if (strpos($errors->getMessage(), 'users_email_unique') !== false) {
                    return $this->badRequest('email_unique', 'Email already registered!');
                } elseif (strpos($errors->getMessage(), 'users_phone_unique') !== false) {
                    return $this->badRequest('phone_unique', 'Phone number already registered!');
                }
            } else {
                return $this->badRequest($errors->getMessage());
            }
        } catch (\Throwable $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
