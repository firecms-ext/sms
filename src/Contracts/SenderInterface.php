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

use FirecmsExt\Sms\Exceptions\DriverErrorException;

/**
 * 发送工具.
 */
interface SenderInterface
{
    /**
     * Get the sender name.
     */
    public function getName(): string;

    /**
     * Send the message immediately.
     *
     * @throws DriverErrorException
     */
    public function send(SmsableInterface $smsable): array;
}
