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

use FirecmsExt\Sms\Contracts\DriverInterface;
use FirecmsExt\Sms\Contracts\SenderInterface;
use FirecmsExt\Sms\Contracts\SmsableInterface;
use FirecmsExt\Sms\Events\SmsMessageSending;
use FirecmsExt\Sms\Events\SmsMessageSent;
use Hyperf\Macroable\Macroable;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Sender implements SenderInterface
{
    use Macroable;

    protected string $name;

    protected DriverInterface $driver;

    protected ContainerInterface $container;

    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(
        string $name,
        array $config,
        ContainerInterface $container
    ) {
        $this->name = $name;
        $this->driver = make($config['driver'], ['config' => $config['config'] ?? []]);
        $this->eventDispatcher = $container->get(EventDispatcherInterface::class);
        $this->container = $container;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function send(SmsableInterface $smsable): array
    {
        $smsable = clone $smsable;

        call_user_func([$smsable, 'build'], $this);

        $this->eventDispatcher->dispatch(new SmsMessageSending($smsable));

        $response = $this->driver->send($smsable);

        $this->eventDispatcher->dispatch(new SmsMessageSent($smsable));

        return $response;
    }
}
