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
namespace FirecmsExt\Sms;

use FirecmsExt\Sms\Contracts\SmsableInterface;
use Hyperf\AsyncQueue\Job;

class QueuedSmsableJob extends Job
{
    public SmsableInterface $smsable;

    public function __construct(SmsableInterface $smsable)
    {
        $this->smsable = $smsable;
    }

    public function handle()
    {
        $this->smsable->send();
    }
}
