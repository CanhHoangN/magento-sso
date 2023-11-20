<?php

namespace SSO\LineChat\Controller\ReqToken;

use GuzzleHttp\Client as HttpClient;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlFactory;
use Magento\Framework\UrlInterface;
use SSO\LineChat\Api\CustomerSSORepositoryInterface;
use SSO\LineChat\Config\LineChat;

class LineAuthController extends Action
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @var AccountManagementInterface
     */
    protected $accountManagement;

    /**
     * @var CustomerInterfaceFactory
     */
    protected $customerInterfaceFactory;

    /**
     * @var UrlInterface
     */
    protected $urlModel;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var CustomerSSORepositoryInterface
     */
    protected $customerSSORepository;

    /**
     * LineAuthController constructor.
     *
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param CustomerFactory $customerFactory
     * @param CustomerSession $customerSession
     * @param AccountManagementInterface $accountManagement
     * @param CustomerInterfaceFactory $customerInterfaceFactory
     * @param UrlFactory $urlFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerSSORepositoryInterface $customerSSORepository
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        CustomerFactory $customerFactory,
        CustomerSession $customerSession,
        AccountManagementInterface $accountManagement,
        CustomerInterfaceFactory $customerInterfaceFactory,
        UrlFactory $urlFactory,
        CustomerRepositoryInterface $customerRepository,
        CustomerSSORepositoryInterface $customerSSORepository
    ) {
        parent::__construct($context);
        $this->resultFactory = $resultFactory;
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
        $this->accountManagement = $accountManagement;
        $this->customerInterfaceFactory = $customerInterfaceFactory;
        $this->urlModel = $urlFactory->create();
        $this->customerRepository = $customerRepository;
        $this->customerSSORepository = $customerSSORepository;
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $defaultUrl = $this->urlModel->getUrl('customer/account/login', ['_secure' => true]);
        if ($this->customerSession->isLoggedIn()) {
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }
        $code = $this->getRequest()->getParam('code');
        // Request to endpoint token Line chat
        // Get access_token, id_token, verify line chat
        $httpClient = new HttpClient();
        $response = $httpClient->post(LineChat::BASE_URL_REQ_TOKEN, [
            'form_params' => [
                'grant_type' => LineChat::GRANT_TYPE,
                'code' => $code,
                'client_id' => LineChat::CLIENT_ID,
                'client_secret' => LineChat::CLIENT_SECRET,
                'redirect_uri' => $this->urlModel->getUrl(LineChat::CALL_BACK_URL_ENDPOINT),
            ],
        ]);
        // Request failed to do something ...
        if ($response->getStatusCode() !== LineChat::RESPONSE_OK) {
            $this->messageManager->addErrorMessage('Login failed');
            return $resultRedirect->setUrl($this->_redirect->error($defaultUrl));
        }
        // Get access token
        $responseData = json_decode($response->getBody(), true);
        $tokenID = $responseData[LineChat::ID_TOKEN];
        // Request to endpoint getting user profiles
        $httpClient = new HttpClient();
        $response = $httpClient->POST(LineChat::BASE_URL_PROFILE_TOKEN_ID, [
            'form_params' => [
                'id_token' => $tokenID,
                'client_id' => LineChat::CLIENT_ID,
                'client_secret' => LineChat::CLIENT_SECRET
            ],
        ]);
        // Request failed to do something ...
        if ($response->getStatusCode() !== LineChat::RESPONSE_OK) {
            $this->messageManager->addErrorMessage('Login failed');
            return $resultRedirect->setUrl($this->_redirect->error($defaultUrl));
        }
        // Response from line chat status: 200
        // Decode profile information
        $responseData = json_decode($response->getBody(), true);
        try {
            $email = $responseData['email'];
            // Check exists line account in system
            $customer = $this->customerSSORepository->getCustomerSSO($email);
            // if not exists, create customer
            if (!$customer->getEmail()) {
                $customer = $this->customerInterfaceFactory->create();
                $customer->setFirstname($responseData['name']);
                $customer->setLastname('SSO');
                $customer->setEmail($email);
                // insert to database
                $customer = $this->accountManagement->createAccount($customer);
            }
            // create session login for customer
            $this->customerSession->setCustomerDataAsLoggedIn($customer);
            // Redirect to user dashboard
            $url = $this->urlModel->getUrl('customer/account/', ['_secure' => true]);
            $resultRedirect->setUrl($this->_redirect->success($url));
            return $resultRedirect;
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Login failed'));
        }
        return $resultRedirect->setUrl($this->_redirect->error($defaultUrl));
    }

}
