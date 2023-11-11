<?php

namespace App\Http\Controllers\API;

use App\Helpers\FCM;
use App\Http\Controllers\ApiController;
use App\Http\Requests\API\ColekRequest;
use App\Http\Requests\API\UserIdRequest;
use App\Models\NotificationHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotificationController extends ApiController
{

 
    public function sendNotificationDevelopment(Request $request)
    {
        try {
            $data = $request->only('title', 'message');
            $to = $request->only('to');
            $logFCM = FCM::android($to)->send($data);
            if ($logFCM['success'] === 1) {
                return $this->requestSuccessWithLog($logFCM);
            } else {
                return $this->badRequestWithLog($logFCM);
            }
        } catch (\Throwable $th) {
            return $this->badRequestWithLog($th);
        }
    }
}
