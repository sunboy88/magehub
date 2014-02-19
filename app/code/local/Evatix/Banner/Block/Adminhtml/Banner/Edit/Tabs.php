<?php

class Evatix_Banner_Block_Adminhtml_Banner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('banner_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('banner')->__('Manage Artist Banner'));
    }

    protected function _beforeToHtml() {
        $this->addTab('main', array(
            'label' => Mage::helper('banner')->__('Banner Information'),
            'title' => Mage::helper('banner')->__('Banner Information'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_banner_edit_tab_main')->toHtml(),
        ));

        $this->addTab('images', array(
            'label' => Mage::helper('banner')->__('Images'),
            'url' => $this->getUrl('*/*/images', array('_current' => true)),
            'class' => 'ajax',
        ));

        return parent::_beforeToHtml();
    }

}
