<?php
Class Nwalkere_Balanceexport_Model_Observer{

    /* Exports an order after it is placed
    *
    * @param Varien_Event_Observer $observer observer object
    *
    * @return boolean
    */
        public function exportCustomData(Varien_Event_Observer $observer)
        {
            ////$customData = $observer->getEvent()->getOrder();
            //Mage::log("observer test!");
            Mage::log($observer["customer"]["entity_id"]);

            if( $observer["customer"]["entity_id"] ){

                $customerId = $observer["customer"]["entity_id"];

                /* @var $customer Mage_Customer_Model_Customer */
                $customer = Mage::getModel('customer/customer')->load($customerId);


                //getStorebalanceexport
                //if (!$customer->getCustomattribute()) {
                //if( $customer->getStorebalanceexportcsv() ){

                    $customer->setStorebalanceexportcsv("999.99");

                    //the original version of this answer was wrong; need to use the resource model.
                    $customer->getResource()->saveAttribute($customer,'storebalanceexportcsv');
                 //}

            }



            return true;

        }
}
?>
