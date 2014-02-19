<?php

class Evatix_Artists_Block_Adminhtml_Featured_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form {

    public function __construct() {
        parent::__construct();
    }

    protected function _prepareForm() {
        $model = Mage::registry('configaration');
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset',
                        array(
                            'legend' => Mage::helper('artists')->__('Configaration')
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

        $fieldset->addField('page_title', 'text', array(
            'name' => 'page_title',
            'label' => Mage::helper('artists')->__('Page Title'),
            'title' => Mage::helper('artists')->__('Page Title'),
            'required' => true
        ));
        
        $fieldset->addField('admin_email', 'text', array(
            'name' => 'admin_email',
            'label' => Mage::helper('artists')->__('Admin Email Address'),
            'title' => Mage::helper('artists')->__('Admin Email Address'),
            'required' => true
        ));

        $fieldset->addField('short_description', 'editor', array(
            'name' => 'short_description',
            'style' => 'height:20em;width:36em',
            'label' => Mage::helper('artists')->__('Short Description'),
            'title' => Mage::helper('artists')->__('Short Description'),
            'required' => true,
            'config' => $wysiwygConfig
        ));

        $fieldset->addField('address', 'editor', array(
            'name' => 'address',
            'style' => 'height:10em;width:36em',
            'label' => Mage::helper('artists')->__('Address'),
            'title' => Mage::helper('artists')->__('Address'),
            'required' => true,
            'config' => $wysiwygConfig
        ));
        
        $fieldset->addField('email_template', 'editor', array(
            'name' => 'email_template',
            'index' => 'email_template',
            'style' => 'height:20em;width:36em',
            'label' => Mage::helper('artists')->__('Email Template'),
            'title' => Mage::helper('artists')->__('Email Template'),
            'required' => true,
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
