<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterUpload\Model;

use DateTime;
use Exception;
use Magento\Framework\DataObject;
use Magento\Framework\Model\AbstractExtensibleModel;
use Websolute\TransporterUpload\Api\Data\UploadInterface;

class UploadModel extends AbstractExtensibleModel implements UploadInterface
{
    const ID = 'upload_id';
    const ACTIVITY_ID = 'activity_id';
    const UPLOADER_TYPE = 'uploader_type';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const CACHE_TAG = 'transporter_upload';
    protected $_cacheTag = 'transporter_upload';
    protected $_eventPrefix = 'transporter_upload';

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return int
     */
    public function getActivityId(): int
    {
        return (int)$this->getData(self::ACTIVITY_ID);
    }

    /**
     * @param int $activityId
     * @return void
     */
    public function setActivityId(int $activityId)
    {
        $this->setData(self::ACTIVITY_ID, $activityId);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return (string)$this->getData(self::STATUS);
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * @return string
     */
    public function getUploaderType(): string
    {
        return (string)$this->getData(self::UPLOADER_TYPE);
    }

    /**
     * @param string $uploaderType
     */
    public function setUploaderType(string $uploaderType)
    {
        $this->setData(self::UPLOADER_TYPE, $uploaderType);
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->getData(self::CREATED_AT));
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getUpdatedAt(): DateTime
    {
        return new DateTime($this->getData(self::UPDATED_AT));
    }

    protected function _construct()
    {
        $this->_init(ResourceModel\UploadResourceModel::class);
    }
}
