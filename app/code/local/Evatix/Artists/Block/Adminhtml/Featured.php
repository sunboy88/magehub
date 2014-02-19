<?php

class Evatix_Artists_Block_Adminhtml_Featured extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {

        $this->_controller = 'adminhtml_featured';
        $this->_blockGroup = 'artists';
        $this->_headerText = Mage::helper('artists')->__('Configaration');
        $this->_addButtonLabel = Mage::helper('artists')->__('Add New Configaration');
        parent::__construct();
        /** Remove Add Button if Grid **/
        $this->_removeButton('add'); 
    }

}
