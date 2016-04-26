<?php

//Installer adds a new custom customer attribute for storing customer balance

//check if store balance is enabled
if (!Mage::helper('enterprise_customerbalance')->isEnabled()) {
     return;
}

$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

//only add the custom attribute if it does not exist
$attribute_exists = $setup->attributeValueExists("customer", "storebalanceexportcsvx");

if( !$attribute_exists ){

	$entityTypeId     = $setup->getEntityTypeId('customer');
	$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
	$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);


	    $setup->addAttribute("customer", "storebalanceexportcsvx",  array(
		"type"     => "varchar",
		"backend"  => "",
		"label"    => "Store Balance (export) d",
		"input"    => "text",
		"source"   => "",
		"visible"  => true,
		"required" => false,
		"default" => "",
		"frontend" => "",
		"unique"     => false,
		"note"       => "Store Balance (export) d"

	    ));


	    $attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "storebalanceexportcsvx");

	    $used_in_forms=array();


	    $attribute->setData("used_in_forms", $used_in_forms)
		->setData("is_used_for_customer_segment", true)
		->setData("is_system", 0)
		->setData("is_user_defined", 1)
		->setData("is_visible", 0)
		->setData("sort_order", 100);
	    $attribute->save();

}



//update the new attribute with customer store balance 
$customers = Mage::getModel('customer/customer')->getCollection();

foreach($customers as $customer){

    $customerId = $customer->getId();

    $currentCustomer = Mage::getModel('customer/customer')->load($customerId);

    $websiteId = $currentCustomer->getWebsiteId();

    $balanceModel = Mage::getModel('enterprise_customerbalance/balance')
    	     ->setCustomerId($customerId)
             ->setWebsiteId($websiteId)
             ->loadByCustomer();

    // check if balance found
    if (!$balanceModel->getId()) {
          $balance = (float) 0;
    }else{

          $balance = $balanceModel->getAmount();
     }

    $currentCustomer->setStorebalanceexportcsvx($balance);

    //the original version of this answer was wrong; need to use the resource model.
    $currentCustomer->getResource()->saveAttribute($currentCustomer,'storebalanceexportcsvx');

    $currentCustomer->save();

}




$installer->endSetup();


?>
