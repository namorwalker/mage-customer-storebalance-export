<?php



$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId     = $setup->getEntityTypeId('customer');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);


//only add the custom attribute if it does not exist
//$storeBalanceAttribute = Mage::getSingleton("eav/config")->getAttribute("customer", "storebalanceexportcsv");

//$test = 1;

/*if (null!==$storeBalanceAttribute->getId()) {
        //attribute exists code here
        $storeBalanceAttribute = Mage::getSingleton("eav/config")->removeAttribute("customer", "storebalanceexportcsv");
}*/


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


//Mage::log($observer["customer"]["entity_id"]);
    $attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "storebalanceexportcsvx");

    /*Mage::log($attribute);
    $setup->addAttributeToGroup(
        $entityTypeId,
        $attributeSetId,
        $attributeGroupId,
        'storebalanceexportcsv',
        '999'  //sort_order
    );*/

    $used_in_forms=array();

    //$used_in_forms[]="adminhtml_customer";
//$used_in_forms[]="checkout_register";
//$used_in_forms[]="customer_account_create";
//$used_in_forms[]="customer_account_edit";
//$used_in_forms[]="adminhtml_checkout";

    $attribute->setData("used_in_forms", $used_in_forms)
        ->setData("is_used_for_customer_segment", true)
        ->setData("is_system", 0)
        ->setData("is_user_defined", 1)
        ->setData("is_visible", 1)
        ->setData("sort_order", 100);
    $attribute->save();

//update the new attribute with customer store balance 
$customers = Mage::getModel('customer/customer')->getCollection();

foreach($customers as $customer){

    $currentCustomer = Mage::getModel('customer/customer')->load($customer->getId());

    $currentCustomer->setStorebalanceexportcsvx("99");

    //the original version of this answer was wrong; need to use the resource model.
    $currentCustomer->getResource()->saveAttribute($currentCustomer,'storebalanceexportcsvx');

    $currentCustomer->save();

}




$installer->endSetup();


?>
