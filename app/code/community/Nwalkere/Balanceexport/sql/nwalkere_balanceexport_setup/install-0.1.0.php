<?php

//Installer adds a new custom customer attribute for storing customer balance


$installer = $this;

$installer->startSetup();

$eavSetup = new Mage_Eav_Model_Entity_Setup('core_setup');

//only add the custom attribute if it does not exist
$attribute_exists = $installer->attributeValueExists("customer", "storebalanceexportcsvx");

if( !$attribute_exists ){

	$entityTypeId     = $eavSetup->getEntityTypeId('customer');
	$attributeSetId   = $eavSetup->getDefaultAttributeSetId($entityTypeId);
	$attributeGroupId = $eavSetup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);


	$eavSetup->addAttribute("customer", "storebalanceexportcsvx",  array(
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


	$attribute = Mage::getSingleton("eav/config")->getAttribute("customer", "storebalanceexportcsvx");

	$used_in_forms=array();


	$attribute->setData("used_in_forms", $used_in_forms)
		->setData("is_used_for_customer_segment", true)
		->setData("is_system", 0)
		->setData("is_user_defined", 1)
		->setData("is_visible", 0)
		->setData("sort_order", 100);
	$attribute->save();

}

Mage::helper('balanceexport/attribute')->synchStoreBalanceAttribute();


$installer->endSetup();


?>
