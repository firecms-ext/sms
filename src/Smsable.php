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

use FirecmsExt\Sms\Contracts\MobileNumberInterface;
use FirecmsExt\Sms\Contracts\SenderInterface;
use FirecmsExt\Sms\Contracts\SmsableInterface;
use FirecmsExt\Sms\Contracts\SmsManagerInterface;
use FirecmsExt\Sms\Strategies\OrderStrategy;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\Contract\CompressInterface;
use Hyperf\Contract\UnCompressInterface;
use Hyperf\Utils\ApplicationContext;

abstract class Smsable implements SmsableInterface, CompressInterface, UnCompressInterface
{
    /**
     * @var string
     */
    public $strategy = OrderStrategy::class;

    /**
     * @var string[]
     */
    public array $senders = [];

    public string $sender;

    public string $from;

    public MobileNumberInterface $to;

    public string $content;

    public string $template;

    public string $signature;

    /**
     * @var array
     */
    public $data = [];

    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }

    public function to(MobileNumberInterface $to): static
    {
        $this->to = $to;

        return $this;
    }

    public function content(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function template(string $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function signature(string $signature): static
    {
        $this->signature = $signature;

        return $this;
    }

    public function with(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } elseif (is_string($key)) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    public function strategy(string $class): static
    {
        $this->strategy = $class;

        return $this;
    }

    public function senders(array $names): static
    {
        $this->senders = $names;

        return $this;
    }

    public function sender(string $name): static
    {
        $this->sender = $name;

        return $this;
    }

    public function send(?SenderInterface $sender = null): array
    {
        return $sender instanceof SenderInterface
            ? $sender->send($this)
            : ApplicationContext::getContainer()->get(SmsManagerInterface::class)->sendNow($this);
    }

    public function queue(?string $queue = null): bool
    {
        return $this->pushQueuedJob($this->newQueuedJob(), $queue);
    }

    public function later(int $delay, ?string $queue = null): bool
    {
        return $this->pushQueuedJob($this->newQueuedJob(), $queue, $delay);
    }

    /**
     * @return static
     */
    public function uncompress(): CompressInterface
    {
        foreach ($this as $key => $value) {
            if ($value instanceof UnCompressInterface) {
                $this->{$key} = $value->uncompress();
            }
        }

        return $this;
    }

    /**
     * @return static
     */
    public function compress(): UnCompressInterface
    {
        foreach ($this as $key => $value) {
            if ($value instanceof CompressInterface) {
                $this->{$key} = $value->compress();
            }
        }

        return $this;
    }

    /**
     * Push the queued SMS message job onto the queue.
     */
    protected function pushQueuedJob(QueuedSmsableJob $job, ?string $queue = null, ?int $delay = null): bool
    {
        $queue = $queue ?: (property_exists($this, 'queue') ? $this->queue : array_key_first(config('async_queue')));

        return ApplicationContext::getContainer()->get(DriverFactory::class)->get($queue)->push($job, (int) $delay);
    }

    /**
     * Make the queued SMS message job instance.
     */
    protected function newQueuedJob(): QueuedSmsableJob
    {
        return new QueuedSmsableJob($this);
    }
}
