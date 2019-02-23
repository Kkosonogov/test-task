<?php

namespace Kkosonogov\Customer\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;

class Status implements SectionSourceInterface
{
    /**
     * @var CustomerRepositoryInterface|CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var Session
     */
    protected $session;

    public function __construct(
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->session = $customerSession;
        $this->customerRepository = $customerRepository;
    }

    public function getSectionData()
    {
        $currentCustomerDataObject = $this->customerRepository->getById($this->session->getCustomerId());
        $status = $currentCustomerDataObject->getCustomAttribute('account_status');

        return [
            'status' => $status,
        ];
    }
}
