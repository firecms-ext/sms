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
namespace FirecmsExt\Sms\Listeners;

use FirecmsExt\Sms\Rules\MobileNumber;
use FirecmsExt\Sms\Rules\MobileNumberFormat;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Validation\Rule;

class BootApplicationListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    public function process(object $event)
    {
        if (! Rule::hasMacro('mobileNumber')) {
            Rule::macro('mobileNumber', function ($regionCodes, string ...$_) {
                return new MobileNumber($regionCodes, ...$_);
            });
        }

        if (! Rule::hasMacro('mobileNumberFormat')) {
            Rule::macro('mobileNumberFormat', function (string $format, ?string $defaultRegion = null) {
                return new MobileNumberFormat($format, $defaultRegion);
            });
        }
    }
}
