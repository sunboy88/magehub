<?php

class Evatix_Artists_Model_Mysql4_Artists extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('artists/artists', 'artists_id');
    }

}