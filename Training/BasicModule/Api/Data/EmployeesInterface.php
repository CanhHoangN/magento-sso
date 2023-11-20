<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Training\BasicModule\Api\Data;

interface EmployeesInterface
{

    const EMAIL = 'email';
    const FIRSTNAME = 'firstName';
    const EMPLOYEES_ID = 'employees_id';
    const EMPLOYEENUMBER = 'employeeNumber';
    const LASTNAME = 'lastName';

    /**
     * Get employees_id
     * @return string|null
     */
    public function getEmployeesId();

    /**
     * Set employees_id
     * @param string $employeesId
     * @return \Training\BasicModule\Employees\Api\Data\EmployeesInterface
     */
    public function setEmployeesId($employeesId);

    /**
     * Get employeeNumber
     * @return string|null
     */
    public function getEmployeeNumber();

    /**
     * Set employeeNumber
     * @param string $employeeNumber
     * @return \Training\BasicModule\Employees\Api\Data\EmployeesInterface
     */
    public function setEmployeeNumber($employeeNumber);

    /**
     * Get lastName
     * @return string|null
     */
    public function getLastName();

    /**
     * Set lastName
     * @param string $lastName
     * @return \Training\BasicModule\Employees\Api\Data\EmployeesInterface
     */
    public function setLastName($lastName);

    /**
     * Get firstName
     * @return string|null
     */
    public function getFirstName();

    /**
     * Set firstName
     * @param string $firstName
     * @return \Training\BasicModule\Employees\Api\Data\EmployeesInterface
     */
    public function setFirstName($firstName);

    /**
     * Get email
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     * @param string $email
     * @return \Training\BasicModule\Employees\Api\Data\EmployeesInterface
     */
    public function setEmail($email);
}

