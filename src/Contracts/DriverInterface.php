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
namespace HyperfExt\Sms\Contracts;

interface DriverInterface
{
    /**
     * Send the message.
     *
     * @throws \HyperfExt\Sms\Exceptions\DriverErrorException
     */
    public function send(SmsableInterface $smsable): array;
}
