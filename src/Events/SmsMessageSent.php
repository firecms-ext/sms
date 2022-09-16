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
namespace FirecmsExt\Sms\Events;

use FirecmsExt\Sms\Contracts\SmsableInterface;

/**
 * 短信发送之后。
 */
class SmsMessageSent
{
    /**
     * The message instance.
     */
    public SmsableInterface $smsable;

    /**
     * Create a new event instance.
     */
    public function __construct(SmsableInterface $smsable)
    {
        $this->smsable = $smsable;
    }
}
