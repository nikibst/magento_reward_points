<?php

$installer = $this;
$installer->startSetup();

$installer->run("
                 ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `rp_amount` DECIMAL( 10, 2 ) NOT NULL;
                 ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `base_rp_amount` DECIMAL( 10, 2 ) NOT NULL;
                 ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `base_rp_amount` DECIMAL( 10, 2 ) NOT NULL;
                 ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `rp_amount` DECIMAL( 10, 2 ) NOT NULL;
                ");


$setup = new Mage_Catalog_Model_Resource_Eav_Mysql4_Setup('core_setup');


$setup->addAttribute('customer', 'customer_rp', array(
    'type' => 'int',
    'input' => 'text',
    'label' => 'Reward Points',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 0,
    'default' => 0,
    'visible_on_front' => 1,
    'source' =>   NULL,
));

$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'customer_rp');
$oAttribute->setData('used_in_forms', array('adminhtml_customer'));
$oAttribute->save();

$setup->addAttribute('catalog_product', 'product_rp', array(
    'type' => 'int',
    'input' => 'text',
    'label' => 'Product Reward Points',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 0,
    'used_in_product_listing' => 1,
    'default' => 0,
    'visible_on_front' => 1,
    'source' =>   NULL,
));

$setup->endSetup();