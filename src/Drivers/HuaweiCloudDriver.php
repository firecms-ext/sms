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
use FirecmsExt\Sms\Exceptions\RequestException;

/**
 * 华为.
 * @see https://support.huaweicloud.com/devg-msgsms/sms_04_0000.html
 */
class HuaweiCloudDriver extends AbstractDriver
{
    protected const ENDPOINT_HOST = 'https://api.rtc.huaweicloud.com:10443';

    protected const ENDPOINT_URI = '/sms/batchSendSms/v1';

    protected const SUCCESS_CODE = '000000';

    public function send(SmsableInterface $smsable): array
    {
        $appKey = $this->config->get('app_key');
        $appSecret = $this->config->get('app_secret');
        $channels = $this->config->get('from', []);

        $endpoint = $this->getEndpoint();
        $headers = $this->getHeaders($appKey, $appSecret);

        $templateId = $smsable->template;
        $messageData = $smsable->data;

        // 短信签名通道号码
        $from = $smsable->from ?: 'default';
        $channel = $channels[$from] ?? '';

        if (empty($channel)) {
            throw new \InvalidArgumentException("From Channel [{$from}] Not Exist");
        }

        $params = [
            'from' => $channel,
            'to' => $smsable->to->toE164(),
            'templateId' => $templateId,
            'templateParas' => json_encode($messageData),
        ];

        try {
            $response = $this->client->request('post', $endpoint, [
                'headers' => $headers,
                'form_params' => $params,
                // 为防止因HTTPS证书认证失败造成API调用失败，需要先忽略证书信任问题
                'verify' => false,
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $result = $response->toArray();

        if ($result['code'] != self::SUCCESS_CODE) {
            throw new DriverErrorException($result['description'], ltrim($result['code'], 'E'), $response);
        }

        return $result;
    }

    protected function getEndpoint(): string
    {
        $endpoint = rtrim($this->config->get('endpoint', self::ENDPOINT_HOST), '/');

        return $endpoint . self::ENDPOINT_URI;
    }

    protected function getHeaders(string $appKey, string $appSecret): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'WSSE realm="SDP",profile="UsernameToken",type="Appkey"',
            'X-WSSE' => $this->buildWsseHeader($appKey, $appSecret),
        ];
    }

    protected function buildWsseHeader(string $appKey, string $appSecret): string
    {
        $now = date('Y-m-d\TH:i:s\Z');
        $nonce = uniqid();
        $passwordDigest = base64_encode(hash('sha256', $nonce . $now . $appSecret));

        return sprintf(
            'UsernameToken Username="%s",PasswordDigest="%s",Nonce="%s",Created="%s"',
            $appKey,
            $passwordDigest,
            $nonce,
            $now
        );
    }
}
