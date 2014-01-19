<?php

class Cansilia_Rp_Model_Sales_Order_Creditmemo_Total_Rp extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $creditMemo)
    {
       $rp = $creditMemo->getOrder()->getRpAmount();
       $baseRp = $creditMemo->getOrder()->getBaseRpAmount();

       $creditMemo->setGrandTotal($creditMemo->getGrandTotal() - $rp);
       $creditMemo->setBaseGrandTotal($creditMemo->getBaseGrandTotal() - $baseRp);
    }
}
