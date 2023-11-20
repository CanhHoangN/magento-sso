<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Training\BasicModule\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Training\BasicModule\Api\Data\EmployeesInterface;
use Training\BasicModule\Api\Data\EmployeesInterfaceFactory;
use Training\BasicModule\Api\Data\EmployeesSearchResultsInterfaceFactory;
use Training\BasicModule\Api\EmployeesRepositoryInterface;
use Training\BasicModule\Model\ResourceModel\Employees as ResourceEmployees;
use Training\BasicModule\Model\ResourceModel\Employees\CollectionFactory as EmployeesCollectionFactory;

class EmployeesRepository implements EmployeesRepositoryInterface
{

    /**
     * @var EmployeesInterfaceFactory
     */
    protected $employeesFactory;

    /**
     * @var EmployeesCollectionFactory
     */
    protected $employeesCollectionFactory;

    /**
     * @var Employees
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ResourceEmployees
     */
    protected $resource;


    /**
     * @param ResourceEmployees $resource
     * @param EmployeesInterfaceFactory $employeesFactory
     * @param EmployeesCollectionFactory $employeesCollectionFactory
     * @param EmployeesSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceEmployees $resource,
        EmployeesInterfaceFactory $employeesFactory,
        EmployeesCollectionFactory $employeesCollectionFactory,
        EmployeesSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->employeesFactory = $employeesFactory;
        $this->employeesCollectionFactory = $employeesCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(EmployeesInterface $employees)
    {
        try {
            $this->resource->save($employees);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the employees: %1',
                $exception->getMessage()
            ));
        }
        return $employees;
    }

    /**
     * @inheritDoc
     */
    public function get($employeesId)
    {
        $employees = $this->employeesFactory->create();
        $this->resource->load($employees, $employeesId);
        if (!$employees->getId()) {
            throw new NoSuchEntityException(__('employees with id "%1" does not exist.', $employeesId));
        }
        return $employees;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->employeesCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(EmployeesInterface $employees)
    {
        try {
            $employeesModel = $this->employeesFactory->create();
            $this->resource->load($employeesModel, $employees->getEmployeesId());
            $this->resource->delete($employeesModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the employees: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($employeesId)
    {
        return $this->delete($this->get($employeesId));
    }
}

