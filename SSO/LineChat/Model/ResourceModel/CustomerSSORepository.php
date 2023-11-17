<?php

namespace SSO\LineChat\Model\ResourceModel;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Exception\LocalizedException;
use SSO\LineChat\Api\CustomerSSORepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;

class CustomerSSORepository implements CustomerSSORepositoryInterface
{
    /**
     * @var CustomerFactory
     */
    private CustomerFactory $_customerFactory;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $_storeManager;

    /**
     * CustomerSSORepository constructor.
     *
     * @param CustomerFactory $customerFactory
     * @param StoreManagerInterface $storeManagerInterface
     */
    public function __construct(
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManagerInterface
    ) {
        $this->_customerFactory = $customerFactory;
        $this->_storeManager = $storeManagerInterface;
    }

    /**
     * @inheritDoc
     * @throws LocalizedException
     */
    public function getCustomerSSO($email, $websiteId = null)
    {
        $customer = $this->_customerFactory->create();
        if ($websiteId === null) {
            $websiteId = $this->_storeManager->getStore()->getWebsiteId()
                ?: $this->_storeManager->getDefaultStoreView()->getWebsiteId();
        }
        if (isset($websiteId)) {
            $customer->setWebsiteId($websiteId);
        }
        $customer->loadByEmail($email);
        return $customer->getDataModel();
    }
}
