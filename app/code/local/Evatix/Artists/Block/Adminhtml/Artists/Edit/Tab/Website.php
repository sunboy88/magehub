<?php

class Evatix_Artists_Block_Adminhtml_Artists_Edit_Tab_Website extends Mage_Adminhtml_Block_Widget_Form {

    public function __construct() {
        parent::__construct();
    }

    protected function _prepareForm() {
        $model = Mage::registry('artists');
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('website_fieldset',
                        array(
                            'legend' => Mage::helper('artists')->__('Website')
                        )
        );


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


        $fieldset->addField('website', 'editor', array(
            'name' => 'website',
            'style' => 'height:20em;width:36em',
            'required' => false,
            'label' => Mage::helper('artists')->__('Websites'),
            'config' => $wysiwygConfig
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
        return Mage::helper('artists')->__('Configaration');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('artists')->__('Configaration');
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
