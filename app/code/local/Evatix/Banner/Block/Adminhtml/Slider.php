<?php
class Evatix_Banner_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {

    $this->_controller = 'adminhtml_slider';
    $this->_blockGroup = 'banner';
    $this->_headerText = Mage::helper('banner')->__('Manage Slider');
    $this->_addButtonLabel = Mage::helper('banner')->__('Add New Slider');
    parent::__construct();
  }
}
