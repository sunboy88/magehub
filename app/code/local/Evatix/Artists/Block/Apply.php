<?php

class Evatix_Artists_Block_Apply extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getArtistConfigaration() {
        $model = Mage::getModel('artists/configaration')->getCollection();
        $data = $model->getData();
        if ($data) {
            return $data[0];
        }
        return array();
    }

}
