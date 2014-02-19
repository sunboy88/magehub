<?php

class Evatix_Banner_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('banner')->__('Manage Slider'));
    }

    protected function _beforeToHtml() {
        $this->addTab('main', array(
            'label' => Mage::helper('banner')->__('Slider Information'),
            'title' => Mage::helper('banner')->__('Slider Information'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_slider_edit_tab_main')->toHtml(),
        ));

        $this->addTab('content', array(
            'label' => Mage::helper('banner')->__('Content'),
            'title' => Mage::helper('banner')->__('Content'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_slider_edit_tab_content')->toHtml(),
        ));

        $this->addTab('images', array(
            'label' => Mage::helper('banner')->__('Images'),
            'url' => $this->getUrl('*/*/images', array('_current' => true)),
            'class' => 'ajax',
        ));
        return parent::_beforeToHtml();
    }

}
