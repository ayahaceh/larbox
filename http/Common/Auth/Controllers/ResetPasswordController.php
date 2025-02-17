<?php

namespace Http\Common\Auth\Controllers;

use App\Http\Controllers\Controller;
use Http\Common\Auth\Requests\ResetPassword\SendCodeRequest;
use Http\Common\Auth\Requests\ResetPassword\VerifyCodeRequest;
use Http\Common\Auth\Requests\ResetPassword\CompleteRequest;

use Modules\User\Models\User;
use Modules\Auth\Services\CodeService;

class ResetPasswordController extends Controller
{
    public function sendCode(SendCodeRequest $request)
    {
        $codeService = new CodeService($request->email);
        $codeService->sendCode();

        return $this->successResponse();
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        return $this->successResponse();
    }

    public function complete(CompleteRequest $request)
    {
        $codeService = new CodeService($request->email);
        $codeService->delete();

        $user = User::query()->where('email', $request->email)->firstOrFail();
        $user->fill($request->validated());
        $user->saveQuietly();

        return $this->successResponse();
    }
}
