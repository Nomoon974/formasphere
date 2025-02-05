<?php

namespace App\Service;

class UserDataProvider
{
    public static function serializeUserData($user): array
    {
        return [
            'id' => $user->getId(),
            'avatar' => $user->getAvatar() ?? '/path/to/default-avatar.png',
            'profileLink' => '/user/' . $user->getId(),
            'logoutLink' => '/logout'
        ];
    }
}
