<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterUpload\Model;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Websolute\TransporterUpload\Api\Data\UploadInterface;
use Websolute\TransporterUpload\Api\Data\UploadSearchResultInterface;
use Websolute\TransporterUpload\Api\Data\UploadSearchResultInterfaceFactory;
use Websolute\TransporterUpload\Api\UploadRepositoryInterface;
use Websolute\TransporterUpload\Model\UploadModelFactory as UploadFactory;
use Websolute\TransporterUpload\Model\ResourceModel\Entity\UploadCollectionFactory;
use Websolute\TransporterUpload\Model\ResourceModel\UploadResourceModel;

class UploadRepository implements UploadRepositoryInterface
{
    /**
     * @var UploadFactory
     */
    private $uploadFactory;

    /**
     * @var UploadCollectionFactory
     */
    private $collectionFactory;

    /**
     * @var UploadSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var UploadResourceModel
     */
    private $uploadResourceModel;

    /**
     * @param UploadModelFactory $uploadFactory
     * @param UploadCollectionFactory $collectionFactory
     * @param UploadSearchResultInterfaceFactory $uploadSearchResultInterfaceFactory
     * @param UploadResourceModel $uploadResourceModel
     */
    public function __construct(
        UploadFactory $uploadFactory,
        UploadCollectionFactory $collectionFactory,
        UploadSearchResultInterfaceFactory $uploadSearchResultInterfaceFactory,
        UploadResourceModel $uploadResourceModel
    ) {
        $this->uploadFactory = $uploadFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $uploadSearchResultInterfaceFactory;
        $this->uploadResourceModel = $uploadResourceModel;
    }

    /**
     * @param int $id
     * @return UploadInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): UploadInterface
    {
        $upload = $this->uploadFactory->create();
        $this->uploadResourceModel->load($upload, $id);
        if (!$upload->getId()) {
            throw new NoSuchEntityException(__('Unable to find TransporterUpload with ID "%1"', $id));
        }
        return $upload;
    }

    /**
     * @param UploadInterface $upload
     * @throws Exception
     */
    public function delete(UploadInterface $upload)
    {
        $this->uploadResourceModel->delete($upload);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return UploadSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): UploadSearchResultInterface
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param int $activityId
     * @param string $uploaderType
     * @param string $status
     * @throws AlreadyExistsException
     */
    public function createOrUpdate(int $activityId, string $uploaderType, string $status)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(UploadModel::ACTIVITY_ID, ['eq' => $activityId]);
        $collection->addFieldToFilter(UploadModel::UPLOADER_TYPE, ['eq' => $uploaderType]);

        /** @var UploadModel $upload */
        if ($collection->count()) {
            $upload = $collection->getFirstItem();
        } else {
            $upload = $this->uploadFactory->create();
            $upload->setActivityId($activityId);
            $upload->setUploaderType($uploaderType);
        }

        $upload->setStatus($status);

        $this->save($upload);
    }

    /**
     * @param UploadInterface $upload
     * @return UploadInterface
     * @throws AlreadyExistsException
     */
    public function save(UploadInterface $upload)
    {
        $this->uploadResourceModel->save($upload);
        return $upload;
    }

    /**
     * @param int $activityId
     * @param string $uploaderType
     * @param string $status
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function update(int $activityId, string $uploaderType, string $status)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(UploadModel::ACTIVITY_ID, ['eq' => $activityId]);
        $collection->addFieldToFilter(UploadModel::UPLOADER_TYPE, ['eq' => $uploaderType]);

        if (!$collection->count()) {
            throw new NoSuchEntityException(__(
                'Non existing upload ~ activityId:%1 ~ uploaderType:%2',
                $activityId,
                $uploaderType
            ));
        }

        /** @var UploadInterface $upload */
        $upload = $collection->getFirstItem();
        $upload->setStatus($status);

        $this->save($upload);
    }

    /**
     * @param int $activityId
     * @return UploadInterface[]
     */
    public function getAllByActivityId(int $activityId): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(UploadModel::ACTIVITY_ID, ['eq' => $activityId]);

        /** @var UploadInterface[] $uploads */
        $uploads = $collection->getItems();

        return $uploads;
    }
}
