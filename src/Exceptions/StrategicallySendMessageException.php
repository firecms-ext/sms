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

use RuntimeException;
use Throwable;

class StrategicallySendMessageException extends RuntimeException
{
    protected array $stack = [];

    public function __construct($message, Throwable $throwable)
    {
        parent::__construct($message, 0);

        $this->appendStack($throwable);
    }

    public function appendStack(Throwable $throwable)
    {
        $this->stack[] = $throwable;
    }

    /**
     * @return Throwable[]
     */
    public function getStack(): array
    {
        return $this->stack;
    }
}
