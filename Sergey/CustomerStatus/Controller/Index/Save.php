<?php

declare(strict_types = 1);

namespace Sergey\CustomerStatus\Controller\Index;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Customers newsletter subscription save controller
 */
class Save extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * Customer session
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param CustomerRepository $customerRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context, 
        \Magento\Customer\Model\Session $customerSession, 
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, 
        \Magento\Store\Model\StoreManagerInterface $storeManager, 
        CustomerRepository $customerRepository
    )
    {
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $customerSession);
        $this->_customerSession = $customerSession;
    }

    /**
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->_redirect('customerstatus/index/');
        }

        $customerId = $this->_customerSession->getCustomerId();
        $customer_status = $this->getRequest()->getParam('customer_status', false);
        if ($customerId === null) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving your customer status.'));
        } else {
            try {
                $customer = $this->customerRepository->getById($customerId);
                $storeId = (int) $this->storeManager->getStore()->getId();
                $customer->setStoreId($storeId);

                $customer->setCustomAttribute('customer_status', $customer_status);
                $this->customerRepository->save($customer);
                $this->messageManager->addSuccessMessage(__('You saved the customer status information.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving your customer status.'));
            }
        }
        return $this->_redirect('customerstatus/index/');
    }

}
