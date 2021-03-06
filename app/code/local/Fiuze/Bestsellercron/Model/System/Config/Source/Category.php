<?php

/**
 * @category    Fiuze
 * @package     Fiuze_Bestsellercron
 * @author     Alena Tsareva <alena.tsareva@webinse.com>
 */
class Fiuze_Bestsellercron_Model_System_Config_Source_Category {

    public function toOptionArray() {
        $categories = Mage::getResourceModel('catalog/category_collection')
                ->addAttributeToSelect('name')
                ->getItems();

        $optionArray = array();
        foreach ($categories as $category) {
            if (!$category->getName()) {
                continue;
            }

            $optionArray[] = array(
                'label' => $category->getName(),
                'value' => $category->getId()
            );
        }
        return $optionArray;
    }

}
