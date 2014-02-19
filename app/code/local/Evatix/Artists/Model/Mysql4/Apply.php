<?php

class Evatix_Artists_Model_Mysql4_Apply extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('artists/apply', 'id');
    }

}