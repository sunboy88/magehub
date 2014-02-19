<?php

class Evatix_Banner_Block_Slider extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getSliderList() {
        $collection = Mage::getModel('banner/slider')->getCollection();
        $collection->getSelect()->where('main_table.status=1');
        return $collection;
        
    }

}
