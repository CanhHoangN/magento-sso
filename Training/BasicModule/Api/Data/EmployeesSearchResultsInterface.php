<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Training\BasicModule\Api\Data;

interface EmployeesSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get employees list.
     * @return \Training\BasicModule\Api\Data\EmployeesInterface[]
     */
    public function getItems();

    /**
     * Set employeeNumber list.
     * @param \Training\BasicModule\Api\Data\EmployeesInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

