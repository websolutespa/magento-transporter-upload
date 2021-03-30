<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterUpload\Model\ResourceModel\Entity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Websolute\TransporterUpload\Model\UploadModel;
use Websolute\TransporterUpload\Model\ResourceModel\UploadResourceModel;

class UploadCollection extends AbstractCollection
{
    protected $_idFieldName = 'upload_id';
    protected $_eventPrefix = 'transporter_upload_collection';
    protected $_eventObject = 'upload_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(UploadModel::class, UploadResourceModel::class);
    }
}
