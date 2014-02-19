<?php

class Evatix_Artists_Block_Adminhtml_Apply extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {

        $this->_controller = 'adminhtml_apply';
        $this->_blockGroup = 'artists';
        $this->_headerText = Mage::helper('artists')->__('Apply Artist Information');
        $this->_addButtonLabel = Mage::helper('artists')->__('Add New Configaration');
        parent::__construct();
        /** Remove Add Button if Grid **/
        $this->_removeButton('add'); 
    }

}
