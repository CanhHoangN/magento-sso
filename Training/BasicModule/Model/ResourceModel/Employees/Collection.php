<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Training\BasicModule\Model\ResourceModel\Employees;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'employees_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Training\BasicModule\Model\Employees::class,
            \Training\BasicModule\Model\ResourceModel\Employees::class
        );
    }

}

