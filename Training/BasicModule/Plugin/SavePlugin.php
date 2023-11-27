<?php

namespace Training\BasicModule\Plugin;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class SavePlugin
{
    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;

    public function __construct(Context $context) {
        $this->_request = $context->getRequest();
        $this->messageManager = $context->getMessageManager();
    }

    public function beforeExecute() {
        // $this->_request->getParams();
        $this->_request->setParams(['plugin' => 1]);
        $this->messageManager->addSuccessMessage(__('Before Save.....'));
        return $this->_request;
    }

}
