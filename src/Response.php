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

use Hyperf\Utils\Contracts\Arrayable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface, Arrayable
{
    private PsrResponseInterface $response;

    public function __construct(PsrResponseInterface $response)
    {
        $this->response = $response;
    }

    public function toArray(): array
    {
        $contentType = $this->response->getHeaderLine('Content-Type');
        $contents = $this->response->getBody()->getContents();

        if (stripos($contentType, 'json') !== false || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        }

        if (stripos($contentType, 'xml') !== false) {
            return json_decode(json_encode(simplexml_load_string($contents)), true);
        }

        return [$contents];
    }

    public function getProtocolVersion()
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function withProtocolVersion($version)
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function getHeaders()
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function hasHeader($name)
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function getHeader($name)
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function getHeaderLine($name)
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function withHeader($name, $value)
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function withAddedHeader($name, $value)
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function withoutHeader($name)
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function getBody()
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function withBody(StreamInterface $body)
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function getStatusCode()
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }

    public function getReasonPhrase()
    {
        return call_user_func_array([$this->response, __FUNCTION__], func_get_args());
    }
}
