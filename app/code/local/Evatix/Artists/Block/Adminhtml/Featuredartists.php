<?php

class Evatix_Artists_Block_Adminhtml_Featuredartists extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {

        $this->_controller = 'adminhtml_featuredartists';
        $this->_blockGroup = 'artists';
        $this->_headerText = Mage::helper('artists')->__('Manage Featured Artists');
        $this->_addButtonLabel = Mage::helper('artists')->__('Add New Artist');
        parent::__construct();
        $this->_removeButton('add'); 
    }

}
