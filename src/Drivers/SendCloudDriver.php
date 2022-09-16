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
use FirecmsExt\Sms\Exceptions\DriverErrorException;

/**
 * @see http://sendcloud.sohu.com/doc/sms/
 */
class SendCloudDriver extends AbstractDriver
{
    public const ENDPOINT_TEMPLATE = 'http://www.sendcloud.net/smsapi/%s';

    public function send(SmsableInterface $smsable): array
    {
        $params = [
            'smsUser' => $this->config->get('sms_user'),
            'templateId' => $smsable->template,
            'msgType' => $smsable->to->getCountryCode() === 86 ? 0 : 2,
            'phone' => $smsable->to->getFullNumberWithIDDPrefix('CN'),
            'vars' => $this->formatTemplateVars($smsable->data),
        ];

        if ($this->config->get('timestamp', false)) {
            $params['timestamp'] = time() * 1000;
        }

        $params['signature'] = $this->generateSign($params, $this->config->get('sms_key'));

        $response = $this->client->post(sprintf(self::ENDPOINT_TEMPLATE, 'send'), $params);

        $result = $response->toArray();

        if (! $result['result']) {
            throw new DriverErrorException($result['message'], $result['statusCode'], $response);
        }

        return $result;
    }

    protected function formatTemplateVars(array $vars): string
    {
        $formatted = [];

        foreach ($vars as $key => $value) {
            $formatted[sprintf('%%%s%%', trim($key, '%'))] = $value;
        }

        return json_encode($formatted, JSON_FORCE_OBJECT);
    }

    protected function generateSign(array $params, string $key): string
    {
        ksort($params);

        return md5(sprintf('%s&%s&%s', $key, urldecode(http_build_query($params)), $key));
    }
}
