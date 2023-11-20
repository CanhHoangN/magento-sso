<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Training\BasicModule\Model;

use Magento\Framework\Model\AbstractModel;
use Training\BasicModule\Api\Data\EmployeesInterface;

class Employees extends AbstractModel implements EmployeesInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Training\BasicModule\Model\ResourceModel\Employees::class);
    }

    /**
     * @inheritDoc
     */
    public function getEmployeesId()
    {
        return $this->getData(self::EMPLOYEES_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEmployeesId($employeesId)
    {
        return $this->setData(self::EMPLOYEES_ID, $employeesId);
    }

    /**
     * @inheritDoc
     */
    public function getEmployeeNumber()
    {
        return $this->getData(self::EMPLOYEENUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setEmployeeNumber($employeeNumber)
    {
        return $this->setData(self::EMPLOYEENUMBER, $employeeNumber);
    }

    /**
     * @inheritDoc
     */
    public function getLastName()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * @inheritDoc
     */
    public function setLastName($lastName)
    {
        return $this->setData(self::LASTNAME, $lastName);
    }

    /**
     * @inheritDoc
     */
    public function getFirstName()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * @inheritDoc
     */
    public function setFirstName($firstName)
    {
        return $this->setData(self::FIRSTNAME, $firstName);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }
}

