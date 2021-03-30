<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterUpload\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class UploadResourceModel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('transporter_upload', 'upload_id');
    }
}
