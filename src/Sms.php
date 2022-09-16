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

use FirecmsExt\Contract\HasMailAddress;
use FirecmsExt\Sms\Contracts\SmsManagerInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * @method static \FirecmsExt\Sms\PendingSms to(HasMailAddress|string $number, null|int|string $defaultRegion = null)
 */
class Sms
{
    public static function __callStatic(string $method, array $args)
    {
        $instance = static::getManager();

        return $instance->{$method}(...$args);
    }

    public static function sender(string $name)
    {
        return (new PendingSms(static::getManager()))->sender($name);
    }

    protected static function getManager()
    {
        return ApplicationContext::getContainer()->get(SmsManagerInterface::class);
    }
}
