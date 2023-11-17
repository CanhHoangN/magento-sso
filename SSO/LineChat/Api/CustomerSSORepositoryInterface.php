<?php

namespace SSO\LineChat\Api;
use Magento\Customer\Api\CustomerRepositoryInterface;

interface CustomerSSORepositoryInterface
{
    /**
     * Check exists customer by login sso linechat
     *
     * @param $email
     * @param null $websiteId
     *
     * @return mixed
     */
    public function getCustomerSSO($email, $websiteId = null);

}
