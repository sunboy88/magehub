<?php

class Evatix_Banner_Block_Adminhtml_Slider_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
    }

    protected function _prepareForm() {
        /** @var $model Mage_Cms_Model_Page */
        $model = Mage::registry('slider_data');

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('content_fieldset', array('legend' => Mage::helper('cms')->__('Content'), 'class' => 'fieldset-wide'));

        /*
       $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
                        array(
                            'add_variables' => false,
                            'add_widgets' => false,
                            'add_images' => false,
                            'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
                            'directives_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'),
                            'directives_url_quoted' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'),
                            'widget_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index'),
                            'files_browser_window_width' => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_width'),
                            'files_browser_window_height' => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_height'),
                            'encode_directives' => true
                        )
        );
        */
        $fieldset->addField('content', 'editor', array(
            'name' => 'content',
            'style' => 'height:20em;width:36em',
            'required' => true,
            'label' => Mage::helper('banner')->__('Description'),
            //'config' => $wysiwygConfig
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
        return Mage::helper('banner')->__('Content');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('banner')->__('Content');
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

}
