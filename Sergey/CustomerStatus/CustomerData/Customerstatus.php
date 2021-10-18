<?php

namespace Sergey\CustomerStatus\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;

class Customerstatus implements SectionSourceInterface
{
    /**
     * @var Session
     */
    protected $customerSession;

    public function __construct(
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    public function getSectionData(): array
    {
        return [
            'customerstatus' => $this->customerSession->getCustomer()->getCustomerStatus()
        ];
    }
}
