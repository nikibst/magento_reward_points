<?php

class Cansilia_Rp_Model_Sales_Order_Invoice_Total_Rp extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
       $rp = $invoice->getOrder()->getRpAmount();
       $baseRp = $invoice->getOrder()->getBaseRpAmount();

       $invoice->setGrandTotal($invoice->getGrandTotal() - $rp);
       $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() - $baseRp);
    }
}
