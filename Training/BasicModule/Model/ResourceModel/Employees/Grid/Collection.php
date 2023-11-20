<?php

namespace Training\BasicModule\Model\ResourceModel\Employees\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

class Collection extends SearchResult
{
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'employees',
        $resourceModel = \Training\BasicModule\Model\ResourceModel\Employees\Collection::class,
        $identifierName = null,
        $connectionName = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $mainTable,
            $resourceModel,
            $identifierName,
            $connectionName
        );
    }

    public function _initSelect()
    {
        $this
            ->getSelect()
            ->from(['main_table' => $this->getMainTable()])
            ->joinLeft(
                ['address' => $this->getTable('employee_address')],
                'main_table.employees_id = address.employees_id',
                ['address.address']
            );
        return $this;
    }
}
