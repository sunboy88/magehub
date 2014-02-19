<?php

class Evatix_Artists_Block_Adminhtml_Artists extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {

        $this->_controller = 'adminhtml_artists';
        $this->_blockGroup = 'artists';
        $this->_headerText = Mage::helper('artists')->__('Manage Artists');
        $this->_addButtonLabel = Mage::helper('artists')->__('Add New Artist');
        parent::__construct();
    }

}
