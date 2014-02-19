<?php

class Evatix_Banner_Block_Banner extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getBannerList() {
        $collection = Mage::getModel('banner/banner')->getCollection();
        $collection->getSelect()->where('main_table.status=1');
        return $collection;

    }

}
