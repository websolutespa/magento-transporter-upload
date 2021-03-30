<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterUpload\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface UploadSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return UploadInterface[]
     */
    public function getItems();

    /**
     * @param UploadInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
