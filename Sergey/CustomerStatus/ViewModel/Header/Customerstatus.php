<?php

namespace Sergey\CustomerStatus\ViewModel\Header;

use Magento\Customer\Model\Session;

class Customerstatus implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var Session
     */
    protected $customerSession;

    public function __construct(
        Session $customerSession
    )
    {
        $this->customerSession = $customerSession;
    }

    /**
     * Return the Customer given the customer Id stored in the session.
     *
     * @return CustomerInterface
     */
    public function getCustomerStatus()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomer()->getCustomerStatus();
        }
    }

}
