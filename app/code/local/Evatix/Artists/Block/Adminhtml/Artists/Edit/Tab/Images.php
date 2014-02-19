<?php

class Evatix_Artists_Block_Adminhtml_Artists_Edit_Tab_Images extends Mage_Adminhtml_Block_Widget_Form {

    public function __construct() {
        parent::__construct();
    }

    protected function _prepareForm() {
        $model = Mage::registry('artists');
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('image_fieldset',
                        array(
                            'legend' => Mage::helper('artists')->__('Images')
                        )
        );

        $fieldset->addField('status', 'file', array(
            'label' => Mage::helper('artists')->__('Image'),
            'name' => 'image',
            
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
        return Mage::helper('artists')->__('Artist Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('artists')->__('Artist Information');
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
