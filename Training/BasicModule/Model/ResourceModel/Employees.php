<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Training\BasicModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Employees extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('employees', 'employees_id');
    }

    /**
     * @return array
     */
    public function getEmployeeInfo()
    {
        $connection = $this->getConnection();
//        $sql = $connection->select()->from(['e' => 'employees'], ['e.employees_id'])->where('e.employees_id = ?', 1);
        $sql =
            $connection->select()
            ->from(['e' => 'employees'], ['e.employees_id'])
            ->joinLeft(
                ['a' => $this->getTable('employee_address')],
                'e.employees_id = a.employees_id',
                ['a.address']
            );
//        $sql =
//            $connection->select()
//                ->from(['e' => 'employees'], ['e.employees_id'])
//                ->joinLeft(
//                    ['a' => $this->getTable('employee_address')],
//                    'e.employees_id = a.employees_id',
//                    ['a.address']
//                );
//        $sql = $sql->exists($connection->select()->from($this->getMainTable()), 'e.employees_id = 1');
//        $sql =
//            $connection->select()
//                ->from(['e' => 'employees'], ['e.employees_id'])
//                ->joinLeft(
//                    ['a' => $this->getTable('employee_address')],
//                    'e.employees_id = a.employees_id',
//                    ['a.address']
//                );
//        $data = [
//            [
//                'employeeNumber' => 'employee3',
//                'lastName' => 'demo'
//            ],
//            [
//                'employeeNumber' => 'employee4',
//                'lastName' => 'demo'
//            ]
//        ];
//        $connection->insertOnDuplicate($this->getMainTable(), $data, ['lastName', 'firstName']);
        return $connection->fetchAll($sql);
    }
}

