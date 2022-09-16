<?php

declare(strict_types=1);
/**
 * This file is part of FirecmsExt Sms.
 *
 * @link     https://www.klmis.cn
 * @document https://www.klmis.cn
 * @contact  zhimengxingyun@klmis.cn
 * @license  https://github.com/firecms-ext/sms/blob/master/LICENSE
 */
namespace FirecmsExt\Sms\Contracts;

use FirecmsExt\Sms\Exceptions\StrategicallySendMessageException;

/**
 * 短信管理.
 */
interface SmsManagerInterface
{
    /**
     * Send the given message immediately.
     *
     * @throws StrategicallySendMessageException
     */
    public function sendNow(SmsableInterface $smsable): array;

    /**
     * Send the given message.
     */
    public function send(SmsableInterface $smsable): bool|array;

    /**
     * Queue the message for sending.
     */
    public function queue(SmsableInterface $smsable, ?string $queue = null): bool;

    /**
     * Deliver the queued message after the given delay.
     */
    public function later(SmsableInterface $smsable, int $delay, ?string $queue = null): bool;
}
