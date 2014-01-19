<?php

class Cansilia_Rp_Model_Adminhtml_Config_Yesno
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('rp')->__('Yes')),
            array('value' => 0, 'label'=>Mage::helper('rp')->__('No')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            0 => Mage::helper('rp')->__('No'),
            1 => Mage::helper('rp')->__('Yes'),
        );
    }

}