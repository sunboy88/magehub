<?php

class Evatix_Artists_Block_Adminhtml_Apply_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('apply_artists_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('artists')->__('Applied Artist Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('artistlist', array(
                'label'     => Mage::helper('artists')->__('Applied Artists Information'),
                'url'       => $this->getUrl('*/*/preview', array('_current' => true)),
               'class'     => 'ajax',
           ));
        return parent::_beforeToHtml();
    }

}
