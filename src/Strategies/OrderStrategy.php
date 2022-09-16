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
namespace FirecmsExt\Sms\Strategies;

use FirecmsExt\Sms\Concerns\HasSenderFilter;
use FirecmsExt\Sms\Contracts\MobileNumberInterface;
use FirecmsExt\Sms\Contracts\StrategyInterface;

class OrderStrategy implements StrategyInterface
{
    use HasSenderFilter;

    public function apply(array $senders, MobileNumberInterface $number): array
    {
        return array_values($this->filterSenders($senders, $number));
    }
}
