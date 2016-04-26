<?php
Class Nwalkere_Balanceexport_Model_Observer{

        public function addStoreBalanceToCustomAttribute(Varien_Event_Observer $observer)
        {

            $block = $observer->getBlock();
            $blockType = $block->getType();

            if ($block instanceof Mage_ImportExport_Block_Adminhtml_Export_Filter && $blockType == 'importexport/adminhtml_export_filter') {

                $attributeExists = Mage::helper('balanceexport/attribute')->attributeExists("customer", "storebalanceexportcsvx");

                //run store balace code for every customer here
                $collection = $block->getCollection();
                //$test = Mage::registry('etm_entity_type');
                if($collection instanceof Mage_Customer_Model_Resource_Attribute_Collection && $attributeExists){

                    Mage::helper('balanceexport/Attribute')->synchStoreBalanceAttribute();

                }


            }

        }

}
?>

