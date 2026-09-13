<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        // メール認証が有効な場合、認証誘導画面へ
        return redirect()->route('verification.notice');
    }
}