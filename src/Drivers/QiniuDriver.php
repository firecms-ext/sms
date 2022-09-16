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
 * 七牛.
 * @see https://developer.qiniu.com/sms/api/5897/sms-api-send-message
 */
class QiniuDriver extends AbstractDriver
{
    protected const ENDPOINT_TEMPLATE = 'https://%s.qiniuapi.com/%s/%s';

    protected const ENDPOINT_VERSION = 'v1';

    public function send(SmsableInterface $smsable): array
    {
        $endpoint = $this->buildEndpoint('sms', 'message/single');

        $data = $smsable->data;

        $params = [
            'template_id' => $smsable->template,
            'mobile' => $smsable->to->getNationalNumber(),
        ];

        if (! empty($data)) {
            $params['parameters'] = $data;
        }

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $headers['Authorization'] = $this->generateSign($endpoint, 'POST', json_encode($params), $headers['Content-Type']);

        $response = $this->client->postJson($endpoint, $params, $headers);

        $result = $response->toArray();

        if (isset($result['error'])) {
            throw new DriverErrorException($result['message'], $result['error'], $response);
        }

        return $result;
    }

    protected function buildEndpoint(string $type, string $function): string
    {
        return sprintf(self::ENDPOINT_TEMPLATE, $type, self::ENDPOINT_VERSION, $function);
    }

    protected function generateSign(string $url, string $method, string $body, string $contentType): string
    {
        $urlItems = parse_url($url);
        $host = $urlItems['host'];
        if (isset($urlItems['port'])) {
            $port = $urlItems['port'];
        } else {
            $port = '';
        }
        $path = $urlItems['path'];
        if (isset($urlItems['query'])) {
            $query = $urlItems['query'];
        } else {
            $query = '';
        }
        // write request uri
        $toSignStr = $method . ' ' . $path;
        if (! empty($query)) {
            $toSignStr .= '?' . $query;
        }
        // write host and port
        $toSignStr .= "\nHost: " . $host;
        if (! empty($port)) {
            $toSignStr .= ':' . $port;
        }
        // write content type
        if (! empty($contentType)) {
            $toSignStr .= "\nContent-Type: " . $contentType;
        }
        $toSignStr .= "\n\n";
        // write body
        if (! empty($body)) {
            $toSignStr .= $body;
        }

        $hmac = hash_hmac('sha1', $toSignStr, $this->config->get('secret_key'), true);

        return 'Qiniu ' . $this->config->get('access_key') . ':' . $this->base64UrlSafeEncode($hmac);
    }

    protected function base64UrlSafeEncode(string $data): string
    {
        $find = ['+', '/'];
        $replace = ['-', '_'];

        return str_replace($find, $replace, base64_encode($data));
    }
}
