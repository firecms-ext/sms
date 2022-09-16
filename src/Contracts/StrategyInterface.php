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

/**
 * 策略.
 */
interface StrategyInterface
{
    /**
     * Apply the strategy and return results.
     */
    public function apply(array $senders, MobileNumberInterface $number): array;
}
