<?php

namespace App\Enum;

class NotificationType
{
    public const INFO         = 'info';
    public const SUCCESS      = 'success';
    public const WARNING      = 'warning';
    public const ERROR        = 'error';

    public const REMINDER     = 'reminder';
    public const ALERT        = 'alert';
    public const SYSTEM       = 'system';
    public const INVITE       = 'invite';
    public const ACHIEVEMENT  = 'achievement';
    public const DEADLINE     = 'deadline';
    public const ANNOUNCEMENT = 'announcement';

    /**
     * Si tu veux récupérer tous les types sous forme de tableau.
     */
    public static function getAllTypes(): array
    {
        return [
            self::INFO,
            self::SUCCESS,
            self::WARNING,
            self::ERROR,
            self::REMINDER,
            self::ALERT,
            self::SYSTEM,
            self::INVITE,
            self::ACHIEVEMENT,
            self::DEADLINE,
            self::ANNOUNCEMENT,
        ];
    }
}
