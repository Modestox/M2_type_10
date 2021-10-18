<?php

declare(strict_types = 1);

namespace Sergey\CustomerStatus\Block\Index;

class Status extends \Magento\Customer\Block\Account\Dashboard
{
    /**
     * @var string
     */
    protected $_template = 'Sergey_CustomerStatus::form/status.phtml';

    /**
     * Return the save action Url.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl('customerstatus/index/save');
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
