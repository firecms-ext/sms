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

use FirecmsExt\Sms\Contracts\HasMailAddress;
use FirecmsExt\Sms\Contracts\SmsManagerInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @method static PendingSms to(HasMailAddress|string $number, null|int|string $defaultRegion = null)
 */
class Sms
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function __callStatic(string $method, array $args)
    {
        $instance = static::getManager();

        return $instance->{$method}(...$args);
    }

    /**
     * 发送工具。
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function sender(string $name): PendingSms
    {
        return (new PendingSms(static::getManager()))->sender($name);
    }

    /**
     * 管理对象。
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected static function getManager(): SmsManagerInterface
    {
        return ApplicationContext::getContainer()->get(SmsManagerInterface::class);
    }
}
