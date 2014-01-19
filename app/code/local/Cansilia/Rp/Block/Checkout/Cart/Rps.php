<?php 

class Cansilia_Rp_Block_Checkout_Cart_Rps extends Mage_Checkout_Block_Cart_Abstract
{
    public function getCouponCode()
    {
        return $this->getQuote()->getCouponCode();
    }

    public function rewardPoints()
    {
    	if (Mage::Helper('customer')->isLoggedIn()) {
    		if ($this->getQuote()->getCustomer()->getCustomerRp() && $this->getQuote()->getCustomer()->getCustomerRp() > 0) {
    			echo $this->__("You currently have <strong>%s</strong> Reward Points.", $this->getQuote()->getCustomer()->getCustomerRp());
    		} else {
    			echo $this->__("You dont have any Reward Points yet.");
    		}
    	}
    	return $this;
    }
}
