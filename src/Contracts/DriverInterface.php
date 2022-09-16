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
 * 驱动.
 */
interface DriverInterface
{
    /**
     * Send the message.
     *
     * @throws DriverErrorException
     */
    public function send(SmsableInterface $smsable): array;
}
