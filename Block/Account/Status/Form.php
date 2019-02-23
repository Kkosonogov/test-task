<?php

namespace Kkosonogov\Customer\Block\Account\Status;

class Form extends \Magento\Customer\Block\Account\Dashboard
{
    /**
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('customer/status/save', ['_secure' => true]);
    }
}