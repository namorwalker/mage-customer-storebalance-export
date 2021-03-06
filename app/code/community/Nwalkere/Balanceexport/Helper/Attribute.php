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
        $customers = Mage::getModel('customer/customer')
            ->getCollection()
            ->addAttributeToSelect('website_id')
            ->addAttributeToSelect('storebalanceexportcsvx')
            ->addAttributeToSelect('entity_id');

        $customerBalancesCollection = Mage::getModel('enterprise_customerbalance/balance')
            ->getCollection();

        $customersWithBalance = $customerBalancesCollection->getSize();

        if($customersWithBalance < 1){
            return;
        }

        $customerBalanceData = array();

        foreach($customerBalancesCollection as $customerBal){
            $customerBalanceData[$customerBal->getCustomerId()] = $customerBal->getAmount();
        }

        $customerBalancesCollection = null;

        foreach($customers as $customer){

            $customerId = $customer->getId();

            if($customerBalanceData[$customerId]){
                $existingBalance = $customerBalanceData[$customerId];

            }else{
                $existingBalance = null;

            }

            $csvxBalance = $customer->getStorebalanceexportcsvx();


            if($existingBalance != null){

                if( $existingBalance !=  $csvxBalance ){
                    $customer->setStorebalanceexportcsvx($existingBalance);
                    $customer->getResource()->saveAttribute($customer,'storebalanceexportcsvx');
                }

            }


        }

    }


}

?>