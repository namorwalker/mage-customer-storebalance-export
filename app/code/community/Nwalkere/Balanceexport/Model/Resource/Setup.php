<?php
class Nwalkere_Balanceexport_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup
{

    /**
     * This method returns true if the attribute exists.
     *
     * @param string|int $entityTypeId
     * @param string|int $attributeId
     * @return bool
     */
    public function attributeValueExists($arg_attribute, $arg_value)	{

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

}
?>
