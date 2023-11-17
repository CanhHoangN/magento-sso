<?php

namespace SSO\LineChat\Block;
use Magento\Customer\Block\Form\Login;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url;
use Magento\Framework\UrlFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;
use SSO\LineChat\Config\LineChat;

class LineChatBlock extends Login
{

    /**
     * @var UrlInterface
     */
    protected $urlModel;

    /**
     * LineChatBlock constructor.
     *
     * @param Context $context
     * @param Session $customerSession
     * @param Url $customerUrl
     * @param array $data
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Url $customerUrl, array $data = [],
        UrlFactory $urlFactory
    ) {
        parent::__construct($context, $customerSession, $customerUrl, $data);
        $this->urlModel = $urlFactory->create();
    }

    /**
     * URL call back
     *
     * @return string
     */
    public function getUrlCallBack()
    {
        return $this->urlModel->getUrl(LineChat::CALL_BACK_URL_ENDPOINT);
    }

    /**
     * URL authentication
     *
     * @return string
     */
    public function getUrlAuthentication() {
        $params = [
            'response_type=code',
            'client_id='.LineChat::CLIENT_ID,
            'redirect_uri='. $this->getUrlCallBack(),
            'state=12345abcde',
            'scope='. LineChat::SCOPE
        ];
        return LineChat::BASE_URL_AUTHENTICATION . implode('&', $params);
    }
}
