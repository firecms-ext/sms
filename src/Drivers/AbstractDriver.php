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

use FirecmsExt\Sms\Client;
use FirecmsExt\Sms\Contracts\DriverInterface;
use Hyperf\Config\Config;

abstract class AbstractDriver implements DriverInterface
{
    protected Client $client;

    protected Config $config;

    /**
     * The driver constructor.
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
        $this->client = new Client($this->getClientOptions());
    }

    /**
     * Return base Guzzle options.
     */
    protected function getClientOptions(): array
    {
        $options = method_exists($this, 'getGuzzleOptions') ? $this->getGuzzleOptions() : [];

        return array_merge($this->config->get('guzzle', []), $options, [
            'base_uri' => method_exists($this, 'getBaseUri') ? $this->getBaseUri() : '',
            'timeout' => method_exists($this, 'getTimeout') ? $this->getTimeout() : 5.0,
        ]);
    }
}
