<?php
/**
 * Created by PhpStorm.
 * User: buster
 * Date: 26/04/16
 * Time: 16:14
 */

class Nwalkere_Balanceexport_Helper_Attribute extends Mage_Core_Helper_Abstract
{
    public function attributeExists($arg_value, $arg_attribute){

        try{

            $attribute_model = Mage::getModel('eav/entity_attribute');
            $attribute_code = $attribute_model->getIdByCode($arg_value, $arg_attribute);
            $attribute = $attribute_model->load($attribute_code);
            $attribute_id = $attribute->getId();

            if( $attribute_code && !empty($attribute_id) ){

                return true;
            }else{

                return false;
            }

        }catch(Exception $e){

            return false;
        }



    }

    public function synchStoreBalanceAttribute(){
        
        $attribute_exists = Mage::helper('balanceexport/attribute')->attributeExists("customer", "storebalanceexportcsvx");

        if( !$attribute_exists ){
            return;
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

    }


}

?>