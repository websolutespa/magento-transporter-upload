<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterUpload\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Websolute\TransporterUpload\Api\Data\UploadInterface;
use Websolute\TransporterUpload\Api\Data\UploadSearchResultInterface;

interface UploadRepositoryInterface
{
    /**
     * @param int $id
     * @return UploadInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): UploadInterface;

    /**
     * @param UploadInterface $upload
     * @return UploadInterface
     */
    public function save(UploadInterface $upload);

    /**
     * @param UploadInterface $upload
     * @return void
     */
    public function delete(UploadInterface $upload);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return UploadSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): UploadSearchResultInterface;

    /**
     * @param int $activityId
     * @param string $uploaderType
     * @param string $status
     */
    public function createOrUpdate(int $activityId, string $uploaderType, string $status);

    /**
     * @param int $activityId
     * @param string $uploaderType
     * @param string $status
     */
    public function update(int $activityId, string $uploaderType, string $status);

    /**
     * @param int $activityId
     * @return UploadInterface[]
     */
    public function getAllByActivityId(int $activityId): array;
}
