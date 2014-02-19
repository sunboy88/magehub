<?php


class EW_Backgrounder_Model_Mysql4_Backgrounds_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('backgrounder/backgrounds');
    }
   

}

