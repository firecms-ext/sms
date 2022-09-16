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
namespace FirecmsExt\Sms\Commands;

use Hyperf\Devtool\Generator\GeneratorCommand;

class GenSmsCommand extends GeneratorCommand
{
    public function __construct()
    {
        parent::__construct('gen:sms');
        $this->setDescription('Create a new SMS message class');
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/message.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(): string
    {
        return $this->getConfig()['namespace'] ?? 'App\\Sms';
    }
}
