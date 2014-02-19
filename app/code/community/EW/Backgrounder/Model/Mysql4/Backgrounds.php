<?php


class EW_Backgrounder_Model_Mysql4_Backgrounds extends Mage_Core_Model_Mysql4_Abstract{
    
    public function _construct()
    {            
        $this->_init('backgrounder/backgrounds', 'id');
    }

}

