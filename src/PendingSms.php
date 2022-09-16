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

use FirecmsExt\Contract\HasMobileNumber;
use FirecmsExt\Sms\Contracts\MobileNumberInterface;
use FirecmsExt\Sms\Contracts\SenderInterface;
use FirecmsExt\Sms\Contracts\SmsableInterface;
use FirecmsExt\Sms\Contracts\SmsManagerInterface;
use FirecmsExt\Sms\Exceptions\InvalidMobileNumberException;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 等待短信
 */
class PendingSms
{
    /**
     * The "to" recipient of the message.
     */
    protected MobileNumberInterface $to;

    protected SmsManagerInterface $manger;

    protected SenderInterface $sender;

    public function __construct(SmsManagerInterface $manger)
    {
        $this->manger = $manger;
    }

    /**
     * Set the recipients of the message.
     *
     * @return $this
     * @throws InvalidMobileNumberException
     */
    public function to(HasMobileNumber|string $number, int|string $defaultRegion = null): static
    {
        $number = $number instanceof HasMobileNumber ? $number->getMobileNumber() : $number;

        $this->to = new MobileNumber($number, $defaultRegion);

        return $this;
    }

    /**
     * Set the sender of the SMS message.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function sender(string $name): static
    {
        $this->sender = ApplicationContext::getContainer()->get(SmsManagerInterface::class)->get($name);

        return $this;
    }

    /**
     * Send a new SMS message instance immediately.
     */
    public function sendNow(SmsableInterface $smsable): array
    {
        return $this->manger->sendNow($this->fill($smsable));
    }

    /**
     * Send a new SMS message instance.
     */
    public function send(SmsableInterface $smsable): bool|array
    {
        return $this->manger->send($this->fill($smsable));
    }

    /**
     * Push the given SMS message onto the queue.
     */
    public function queue(SmsableInterface $smsable, ?string $queue = null): bool
    {
        return $this->manger->queue($this->fill($smsable), $queue);
    }

    /**
     * Deliver the queued SMS message after the given delay.
     */
    public function later(SmsableInterface $smsable, int $delay, ?string $queue = null): bool
    {
        return $this->manger->later($this->fill($smsable), $delay, $queue);
    }

    /**
     * Populate the SMS message with the addresses.
     */
    protected function fill(SmsableInterface $smsable): SmsableInterface
    {
        $smsable->to($this->to);
        if ($this->sender) {
            $smsable->sender($this->sender->getName());
        }
        return $smsable;
    }
}
