<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Carbon;

class TokenHelper
{
    /**
     * Create token for authorization
     *
     * @param User $user
     * @return array
     */
    public static function generateToken(User $user)
    {
        $token = $user->createToken($user->id);
        return [
            'access_token' => $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->format('Y-m-d H:i:s')
        ];
    }
}
