<?php

class Evatix_Artists_Block_Category extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getArtistCategory() {
        $collection = Mage::getModel('artists/category')->getCollection();
        return $collection;
    }

}
