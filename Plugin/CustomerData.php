<?php

namespace Kkosonogov\Customer\Plugin;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Helper\View;

class CustomerData
{
    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var View
     */
    private $customerViewHelper;

    /**
     * @param CurrentCustomer $currentCustomer
     * @param View $customerViewHelper
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        View $customerViewHelper
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerViewHelper = $customerViewHelper;
    }

    /**
     * @param \Magento\Customer\CustomerData\Customer $subject
     * @param $result
     */
    public function afterGetSectionData(\Magento\Customer\CustomerData\Customer $subject, $result)
    {
        $result['status'] = $this->currentCustomer->getCustomer()->getCustomAttribute('account_status')->getValue();

        return $result;
    }
}