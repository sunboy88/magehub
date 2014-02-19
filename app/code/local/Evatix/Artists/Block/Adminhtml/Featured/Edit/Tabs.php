<?php

class Evatix_Artists_Block_Adminhtml_Featured_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('featured_artists_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('artists')->__('Configaration'));
    }

    protected function _beforeToHtml() {
        
        //$this->addTab('artistlist', array(
        //        'label'     => Mage::helper('artists')->__('Featured Artists'),
        //        'url'       => $this->getUrl('*/*/artist', array('_current' => true)),
         //       'class'     => 'ajax',
         //   ));
        
        $this->addTab('main', array(
            'label' => Mage::helper('artists')->__('Configaration'),
            'title' => Mage::helper('artists')->__('Configaration'),
            'content' => $this->getLayout()->createBlock('artists/adminhtml_featured_edit_tab_main')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }

}
