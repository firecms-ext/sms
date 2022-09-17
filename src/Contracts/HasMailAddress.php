<?php

declare(strict_types=1);
/**
 * This file is part of FirecmsExt Contract.
 *
 * @link     https://www.klmis.cn
 * @document https://www.klmis.cn
 * @contact  zhimengxingyun@klmis.cn
 * @license  https://github.com/firecms-ext/contract/blob/master/LICENSE
 */
namespace FirecmsExt\Contracts;

interface HasMailAddress
{
    /**
     * Get the mail address of the entity.
     */
    public function getMailAddress(): ?string;

    /**
     * Get the mail address display name of the entity.
     */
    public function getMailAddressDisplayName(): ?string;
}
