<?php

class Evatix_Banner_Block_Adminhtml_Slider_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form {

    public function __construct() {
        parent::__construct();
    }

    protected function _prepareForm() {
        $model = Mage::registry('slider_data');

        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset',
                        array(
                            'legend' => Mage::helper('banner')->__('Slider Information')
                        )
        );


        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('banner')->__('Title'),
            'title' => Mage::helper('banner')->__('Title'),
            'required' => true
        ));

        $fieldset->addField('link', 'text', array(
            'name' => 'link',
            'label' => Mage::helper('banner')->__('Link'),
            'title' => Mage::helper('banner')->__('Link'),
            'required' => true
        ));



        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('banner')->__('Status'),
            'name' => 'status',
            'required' => true,
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('banner')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('banner')->__('Disabled'),
                ),
            ),
        ));

        
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel() {
        return Mage::helper('banner')->__('Slider Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('banner')->__('Slider Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab() {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden() {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action) {
        return true;
    }

}
