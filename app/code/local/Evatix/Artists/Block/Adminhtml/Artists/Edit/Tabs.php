<?php

class Evatix_Artists_Block_Adminhtml_Artists_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('artists_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('artists')->__('Manage Artist'));
    }

    protected function _beforeToHtml() {
        $this->addTab('main', array(
            'label' => Mage::helper('artists')->__('Artist Information'),
            'title' => Mage::helper('artists')->__('Artist Information'),
            'content' => $this->getLayout()->createBlock('artists/adminhtml_artists_edit_tab_main')->toHtml(),
        ));

            $this->addTab('images', array(
                'label'     => Mage::helper('artists')->__('Images'),
                'url'       => $this->getUrl('*/*/images', array('_current' => true)),
                'class'     => 'ajax',
            ));

         $this->addTab('video', array(
            'label' => Mage::helper('artists')->__('Video'),
            'title' => Mage::helper('artists')->__('Video'),
            'content' => $this->getLayout()->createBlock('artists/adminhtml_artists_edit_tab_video')->toHtml(),
        ));

        $this->addTab('configaration', array(
            'label' => Mage::helper('artists')->__('Configaration'),
            'title' => Mage::helper('artists')->__('Configaration'),
            'content' => $this->getLayout()->createBlock('artists/adminhtml_artists_edit_tab_configaration')->toHtml(),
        ));

        $this->addTab('website', array(
            'label' => Mage::helper('artists')->__('Website'),
            'title' => Mage::helper('artists')->__('Website'),
            'content' => $this->getLayout()->createBlock('artists/adminhtml_artists_edit_tab_website')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}
