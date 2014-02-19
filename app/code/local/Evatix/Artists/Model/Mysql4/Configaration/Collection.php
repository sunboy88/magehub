<?php

class Evatix_Artists_Model_Mysql4_Configaration_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('artists/configaration');
    }

}