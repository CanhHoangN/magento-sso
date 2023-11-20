<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Training\BasicModule\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface EmployeesRepositoryInterface
{

    /**
     * Save employees
     * @param \Training\BasicModule\Api\Data\EmployeesInterface $employees
     * @return \Training\BasicModule\Api\Data\EmployeesInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Training\BasicModule\Api\Data\EmployeesInterface $employees
    );

    /**
     * Retrieve employees
     * @param string $employeesId
     * @return \Training\BasicModule\Api\Data\EmployeesInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($employeesId);

    /**
     * Retrieve employees matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Training\BasicModule\Api\Data\EmployeesSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete employees
     * @param \Training\BasicModule\Api\Data\EmployeesInterface $employees
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Training\BasicModule\Api\Data\EmployeesInterface $employees
    );

    /**
     * Delete employees by ID
     * @param string $employeesId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($employeesId);
}

