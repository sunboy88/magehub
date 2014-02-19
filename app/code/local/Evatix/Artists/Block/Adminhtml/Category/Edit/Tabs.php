<?php

class Evatix_Artists_Block_Adminhtml_Category_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('artists_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('artists')->__('Manage Artist'));
    }

    protected function _beforeToHtml() {
        $this->addTab('main', array(
            'label' => Mage::helper('artists')->__('Artist Category Information'),
            'title' => Mage::helper('artists')->__('Artist Category Information'),
            'content' => $this->getLayout()->createBlock('artists/adminhtml_category_edit_tab_main')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}
