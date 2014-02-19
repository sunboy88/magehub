<?php

class Evatix_Artists_Block_Adminhtml_Category_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form {

    public function __construct() {
        parent::__construct();
    }

    protected function _prepareForm() {
        $model = Mage::registry('artists_category');
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset',
                        array(
                            'legend' => Mage::helper('artists')->__('Artist Category')
                        )
        );


        $fieldset->addField('category_name', 'text', array(
            'name' => 'category_name',
            'index' => 'category_name',
            'label' => Mage::helper('artists')->__('Name'),
            'title' => Mage::helper('artists')->__('Name'),
            'required' => true
        ));

        $fieldset->addField('thumbnail', 'image', array(
            'label' => Mage::helper('artists')->__('Thumbnail'),
            'required' => false,
            'name' => 'thumbnail',
        ));

        $fieldset->addField('main_image', 'image', array(
            'label' => Mage::helper('artists')->__('Base Image'),
            'required' => false,
            'name' => 'main_image',
        ));

        $fieldset->addField('content', 'editor', array(
            'name' => 'content',
            'label' => Mage::helper('artists')->__('Content'),
            'title' => Mage::helper('artists')->__('Content'),
            'required' => true
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
        return Mage::helper('artists')->__('Artist Category');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('artists')->__('Artist Category');
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
