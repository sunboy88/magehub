<?php

class Evatix_Artists_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {

        $this->_controller = 'adminhtml_category';
        $this->_blockGroup = 'artists';
        $this->_headerText = Mage::helper('artists')->__('Artist Category');
        $this->_addButtonLabel = Mage::helper('artists')->__('Add New Artist Category');
        parent::__construct();
    }

}
