<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Training\BasicModule\Controller\Adminhtml\Employees;

use Magento\Framework\Exception\LocalizedException;
use Training\BasicModule\Model\Employees;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    protected $collection;
    protected $employees;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Data\Collection\AbstractDb $collection
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->collection = $collection;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('employees_id');
            /**
             * @var Employees $model
             */
            $model = $this->_objectManager->create(Employees::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Employees no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $model->setData($data);

            try {
                $this->employees->setEmail('abcxyz@gmail.com');
                $model->getResource()->getEmployeeInfo();
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Employees.'));
                $this->dataPersistor->clear('training_basicmodule_employees');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['employees_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Employees.'));
            }

            $this->dataPersistor->set('training_basicmodule_employees', $data);
            return $resultRedirect->setPath('*/*/edit', ['employees_id' => $this->getRequest()->getParam('employees_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

