<?php

class Evatix_Artists_Model_Mysql4_Category extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('artists/category', 'id');
    }

}