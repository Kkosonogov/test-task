<?php

namespace Kkosonogov\Customer\Setup;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\ResourceModel\Attribute;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Config
     */
    private $eavConfig;

    private $attributeResource;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     * @param Attribute $attributeResource
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig,
        Attribute $attributeResource
    ){
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
        $this->attributeResource       = $attributeResource;
    }

    /**
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'account_status');

        $used_in_forms = [
            'adminhtml_customer'
        ];

        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'account_status',
            [
                'label' => 'Account Status',
                'input' => 'text',
                'required' => false,
                'system' => false,
                'default' => '3',
                'position' => 102,
                'filterable' => true,
                'is_user_defined' => false,
            ]
        );

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'account_status');
        $attribute->setData('used_in_forms', $used_in_forms);
        $this->attributeResource->save($attribute);

        $setup->endSetup();
    }
}