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

interface SmsManagerInterface
{
    /**
     * Send the given message immediately.
     *
     * @throws \FirecmsExt\Sms\Exceptions\StrategicallySendMessageException
     */
    public function sendNow(SmsableInterface $smsable): array;

    /**
     * Send the given message.
     *
     * @return array|bool
     */
    public function send(SmsableInterface $smsable);

    /**
     * Queue the message for sending.
     */
    public function queue(SmsableInterface $smsable, ?string $queue = null): bool;

    /**
     * Deliver the queued message after the given delay.
     */
    public function later(SmsableInterface $smsable, int $delay, ?string $queue = null): bool;
}
