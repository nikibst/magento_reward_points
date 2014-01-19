<?php

class Cansilia_Rp_Model_Sales_Observer
{  
    public function sales_order_place_after($observer)
    {
        if (Mage::getStoreConfig('rp_options/on_products_config/on_product_enable') == 1) {

            $order = $observer->getEvent()->getOrder();
            $items = $order->getAllItems();

            if ($items) {
                foreach ($items as $item) {
                    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $item->getSku(), array('product_rp')); 
                    $totalRps[] = $product->getProductRp();
                }

                $total = array_sum($totalRps);

                $customerRp = Mage::getModel('customer/customer')->load($order->getCustomerId());
                $customerRp->setCustomerRp($customerRp->getCustomerRp() + $total);
                if (Mage::getStoreConfig('rp_options/general_config/reward_points_limit') < $customerRp->getCustomerRp()) {
                    $customerRp->setCustomerRp(Mage::getStoreConfig('rp_options/general_config/reward_points_limit'));
                }
                try {
                    $customerRp->save();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } 
            if (Mage::getSingleton('core/session')->getRewardPoints())
            {
                $customer_rps = Mage::getModel('customer/customer')->load($order->getCustomerId())->getCustomerRp();
                $customerRp->setCustomerRp($customer_rps - Mage::getSingleton('core/session')->getRewardPoints())->save();
                Mage::getSingleton('core/session')->unsRewardPoints();
            }
        }    
    }

    public function review_save_after($observer)
    {
        if (Mage::getStoreConfig('rp_options/on_review_config/on_review_enable') == 1) {
            $customer = Mage::getSingleton('customer/session');
            $reviewPoints = Mage::getStoreConfig('rp_options/on_review_config/on_review_reward_points');
            $customerRp = Mage::getModel('customer/customer')->load($customer->getId());
            $customerRp->setCustomerRp($customerRp->getCustomerRp() + (float)$reviewPoints);
            if (Mage::getStoreConfig('rp_options/general_config/reward_points_limit') < $customerRp->getCustomerRp()) {
                    $customerRp->setCustomerRp(Mage::getStoreConfig('rp_options/general_config/reward_points_limit'));
            }

            try {
                $customerRp->save();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function sendfriend_product($observer)
    {
        
        if (Mage::getStoreConfig('rp_options/on_email_friend/on_email_enable') == 1) {
            $customer = Mage::getSingleton('customer/session');
            $friendPoints = Mage::getStoreConfig('rp_options/on_email_friend/on_email_reward_points');
            $customerRp = Mage::getModel('customer/customer')->load($customer->getId());
            $customerRp->setCustomerRp($customerRp->getCustomerRp() + (float)$friendPoints);
            if (Mage::getStoreConfig('rp_options/general_config/reward_points_limit') < $customerRp->getCustomerRp()) {
                    $customerRp->setCustomerRp(Mage::getStoreConfig('rp_options/general_config/reward_points_limit'));
            }
            try {
                $customerRp->save();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function customer_register_success($observer)
    {
        $customerRp = $observer->getEvent()->getCustomer();
        if (Mage::getStoreConfig('rp_options/on_customer_register/on_register_enable') == 1) {
            $registerPoints = (float)Mage::getStoreConfig('rp_options/on_customer_register/on_register_reward_points');
            $customerRp->setCustomerRp((float)$registerPoints);
            try {
                $customerRp->save();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
