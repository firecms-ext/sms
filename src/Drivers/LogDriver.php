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
namespace FirecmsExt\Sms\Drivers;

use FirecmsExt\Sms\Contracts\SmsableInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * 日志.
 */
class LogDriver extends AbstractDriver
{
    /**
     * The Logger instance.
     */
    protected LoggerInterface $logger;

    public function __construct(ContainerInterface $container, array $config)
    {
        parent::__construct($config);

        $this->logger = $container->get(LoggerFactory::class)->get(
            $config['name'] ?? 'sms.local',
            $config['group'] ?? 'default'
        );
    }

    public function send(SmsableInterface $smsable): array
    {
        $log = sprintf(
            "To: %s | Content: \"%s\" | Template: \"%s\" | Signature: \"%s\" | From: \"%s\" | Data: %s\n",
            $smsable->to->toE164() ?? '',
            $smsable->content ?? '',
            $smsable->template ?? '',
            $smsable->signature ?? '',
            $smsable->from ?? '',
            json_encode($smsable->data ?? [])
        );

        $this->logger->debug($log);

        return [];
    }
}
