<?php

class Evatix_Artists_Block_Adminhtml_Artists_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'artists';
        $this->_controller = 'adminhtml_artists';

        $this->_updateButton('save', 'label', Mage::helper('artists')->__('Save Page'));
        $this->_updateButton('delete', 'label', Mage::helper('artists')->__('Delete Page'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('web_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'web_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'web_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText() {
        if (Mage::registry('artists') && Mage::registry('artists')->getId()) {
            return Mage::helper('artists')->__("Edit Artist Information '%s'", $this->htmlEscape(Mage::registry('artists')->getTitle()));
        } else {
            return Mage::helper('artists')->__('New Artist');
        }
    }

}