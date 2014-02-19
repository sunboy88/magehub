<?php

class Evatix_Artists_Block_Adminhtml_Apply_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'artists';
        $this->_controller = 'adminhtml_apply';
        $this->_removeButton('delete');
        $this->_removeButton('save');
        $this->_removeButton('reset');
    }

    public function getHeaderText() {
        return Mage::helper('artists')->__("Applied Artist Information");
        
    }

}