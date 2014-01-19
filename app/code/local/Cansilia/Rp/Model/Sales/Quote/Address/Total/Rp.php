<?php
class Cansilia_Rp_Model_Sales_Quote_Address_Total_Rp extends Mage_Sales_Model_Quote_Address_Total_Abstract{
    
    protected $_code = 'rp';
 
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        if (Mage::getSingleton('core/session')->getRewardPoints())
        {
            if ($address->getAddressType() == 'shipping') {
                parent::collect($address);

            $rp_value = Mage::getStoreConfig('rp_options/general_config/reward_points_price');
            $rp_sent =   Mage::getSingleton('core/session')->getRewardPoints();
            $total = $rp_value * $rp_sent;
                $address->setRpAmount($total);
                $address->setBaseRpAmount($total);
                $address->setGrandTotal($address->getGrandTotal() - $address->getRpAmount());
                $address->setBaseGrandTotal($address->getBaseGrandTotal() - $address->getBaseRpAmount());
           
            }
        }  else {
                $address->setRpAmount(0);
                $address->setBaseRpAmount(0);
        }
    }
 
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if (Mage::getSingleton('core/session')->getRewardPoints())
        {
            if ($address->getAddressType() == 'shipping') {
                $amt = $address->getRpAmount();
                $address->addTotal(array(
                        'code'=>$this->getCode(),
                        'title'=>Mage::helper('rp')->__('Reward Points Discount'),
                        'value'=> -$amt
                ));
                return $this;
            }
        }
    }
}