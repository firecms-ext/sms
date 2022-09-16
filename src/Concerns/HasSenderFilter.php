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
namespace FirecmsExt\Sms\Concerns;

use FirecmsExt\Sms\Contracts\MobileNumberInterface;

trait HasSenderFilter
{
    protected function filterSenders(array $senders, MobileNumberInterface $number): array
    {
        $region = strtolower($number->getRegionCode());
        $output = [];
        foreach ($senders as $key => $value) {
            if (is_array($value)) {
                if (in_array($region, array_map('strtolower', $value))) {
                    $output[] = $key;
                }
            } else {
                $output[] = $value;
            }
        }
        return $output;
    }
}
