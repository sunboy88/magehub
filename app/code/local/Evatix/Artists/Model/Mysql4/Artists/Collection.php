<?php

class Evatix_Artists_Model_Mysql4_Artists_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('artists/artists');
    }

}