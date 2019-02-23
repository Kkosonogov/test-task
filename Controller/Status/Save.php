<?php
/**
 * Created by PhpStorm.
 * User: Kirill.Kosonogov
 * Date: 2/21/2019
 * Time: 9:05 PM
 */

namespace Kkosonogov\Customer\Controller\Status;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

class Save extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var CustomerRepositoryInterface|CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param Validator $formKeyValidator
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Validator $formKeyValidator,
        CustomerRepositoryInterface $customerRepository
    )
    {
        parent::__construct($context);
        $this->session = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $accountStatus = $this->getRequest()->getParam('account_status');
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey) {

            try {
                $currentCustomerDataObject = $this->customerRepository->getById($this->session->getCustomerId());

                $currentCustomerDataObject->setCustomAttribute('account_status', $accountStatus);
                $this->customerRepository->save($currentCustomerDataObject);
                $this->messageManager->addSuccessMessage('Success');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Error'));
            }
        }

        return $resultRedirect->setPath('*/*/form');
    }
}