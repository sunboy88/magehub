<?php

class Evatix_Artists_Block_Artists extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getArtists() {
        if (!$this->hasData('artists')) {
            $this->setData('artists', Mage::registry('artists'));
        }
        return $this->getData('artists');
    }
}
