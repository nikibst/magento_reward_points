<?php
class Cansilia_Rp_RpController extends Mage_Checkout_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
      	$this->renderLayout();
	}

	public function postAction()
	{
		if ( Mage::Helper('customer')->isLoggedIn() ) {
			if (!$this->_getCart()->getQuote()->getItemsCount()) {
            $this->_goBack();
            return;
	        }
			$customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();
			$customer = Mage::getModel('customer/customer')->load($customer_id);
			$customer_rps = Mage::getModel('customer/customer')->load($customer_id)->getCustomerRp();

			if ($this->getRequest()->getParam('reward_points') && $this->getRequest()->getParam('remove1') == 0) {

				if ((float)$this->getRequest()->getParam('reward_points') <= (float)$customer_rps) {
					if ((float)$this->getRequest()->getParam('reward_points') * (float)Mage::getStoreConfig('rp_options/general_config/reward_points_price') <= (float)Mage::helper('checkout/cart')->getQuote()->getGrandTotal()) {

						Mage::getSingleton('core/session')->setRewardPoints(Mage::getSingleton('core/session')->getRewardPoints()
																			+ $this->getRequest()->getParam('reward_points'));

						$this->_getSession()->addSuccess($this->__(' %s Reward Points have been successfully applied on your order!',
						           Mage::getSingleton('core/session')->getRewardPoints()));
					} else {
						$this->_getSession()->addError($this->__('Reward Points discount cannot exceed order\'s Grand Total.'));
					}
					
				} else {
					$this->_getSession()->addError($this->__('Operation failed. Amount given exceeds your current Reward Points Balance.
															 Your currently have: %s Reward Points.',
						           $customer_rps));
				}
				

			} elseif ($this->getRequest()->getParam('remove1') == 1) {

				$this->_getSession()->addSuccess($this->__('Operation cancelled. %s Reward Points has been returned to your balance.', 
											Mage::getSingleton('core/session')->getRewardPoints()));
				Mage::getSingleton('core/session')->unsRewardPoints();

			} else {
				$this->_getSession()->addError($this->__('Insufficient Reward Points.'));
			}
		} else {
			$this->_getSession()->addError($this->__('You have to login to use the Reward Points System.'));	
		}

		$this->_redirect('checkout/cart');
	}

	public function _getCart()
	{
		return Mage::getSingleton('checkout/session');
	}

	protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }
}