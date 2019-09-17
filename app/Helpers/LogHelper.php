<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;

class LogHelper
{
    public const LEVEL_DEBUG = 'debug';
    public const LEVEL_INFO = 'info';
    public const LEVEL_NOTICE = 'notice';
    public const LEVEL_WARNING = 'warning';
    public const LEVEL_ERROR = 'error';
    public const LEVEL_CRITICAL = 'critical';
    public const LEVEL_ALERT = 'alert';
    public const LEVEL_EMERGENCY = 'emergency';

    protected const AVAILABLE_LEVELS = [
        self::LEVEL_EMERGENCY,
        self::LEVEL_ALERT,
        self::LEVEL_CRITICAL,
        self::LEVEL_ERROR,
        self::LEVEL_WARNING,
        self::LEVEL_NOTICE,
        self::LEVEL_INFO,
        self::LEVEL_DEBUG
    ];

    protected const DEFAULT_LOG_LEVEL = self::LEVEL_DEBUG;

    public static function storeException(Exception $exception, $level = self::DEFAULT_LOG_LEVEL): void
    {
        if (!in_array($level, self::AVAILABLE_LEVELS, 1)) {
            $level = self::DEFAULT_LOG_LEVEL;
        }

        Log::$level(mb_strtoupper($level) . ' ' . $exception->getCode() . ': ' . PHP_EOL .
            $exception->getMessage() . PHP_EOL . 'Line ' . $exception->getLine() . ' in file ' .
            $exception->getFile() . PHP_EOL . PHP_EOL,
            [
//                'user_id' => WpUserFacade::getUserId(),
                'url' => request()->url(),
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'protocol' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
                'input' => request()->all(),
            ]);
    }

}
