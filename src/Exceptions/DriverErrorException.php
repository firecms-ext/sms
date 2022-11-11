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
namespace FirecmsExt\Sms\Exceptions;

use Psr\Http\Message\ResponseInterface;

class DriverErrorException extends \RuntimeException
{
    public ResponseInterface $response;

    public function __construct(string $message, $code = null, ResponseInterface $response = null, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
    }

    final public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
