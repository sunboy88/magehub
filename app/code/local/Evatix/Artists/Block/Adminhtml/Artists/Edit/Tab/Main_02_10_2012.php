<?php

class Evatix_Artists_Block_Adminhtml_Artists_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form {

    public function __construct() {
        parent::__construct();
    }

    protected function _prepareForm() {
        $model = Mage::registry('artists');
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset',
                        array(
                            'legend' => Mage::helper('artists')->__('Artists Information')
                        )
        );


        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('artists')->__('Title'),
            'title' => Mage::helper('artists')->__('Title'),
            'required' => true
        ));

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('artists')->__('Artist Name'),
            'title' => Mage::helper('artists')->__('Artist Name'),
            'required' => true
        ));

        $fieldset->addField('email_address', 'text', array(
            'name' => 'email_address',
            'label' => Mage::helper('artists')->__('Artist Email Address'),
            'title' => Mage::helper('artists')->__('Artist Email Address'),
            'required' => true,
            'class' => 'validate-email input-text'
        ));

        /** Generate Category List * */
        $catgoryList = array();
        $tableName = Mage::getSingleton('core/resource')->getTableName('artists_category');
        $sql = "SELECT * from " . $tableName;
        $readConn = Mage::getSingleton('core/resource')->getConnection('core_read');
        try {
            $result = $readConn->fetchAll($sql);
        } catch (Exception $ex) {
            $catgoryList = array();
        }
        array_push(
                $catgoryList,
                array(
                    'value' => 0,
                    'label' => '--Select Category--'
                )
        );
        foreach ($result as $value) {
            array_push(
                    $catgoryList,
                    array(
                        'value' => $value['id'],
                        'label' => $value['category_name']
                    )
            );
        }

        $tableName = Mage::getSingleton('core/resource')->getTableName('artists_category_rel');
        $sql = "SELECT * from " . $tableName." WHERE artists_id=".$model->getArtistsId();
        try {
            $result = $readConn->fetchAll($sql);
            foreach ($result as $value) {
                $categoryIds[] = $value['category_id'];
            }
        } catch (Exception $ex) {
            $categoryIds = array();
        }
        /** Generate Category List * */
        $fieldset->addField('category_id', 'multiselect', array(
            'label' => Mage::helper('artists')->__('Category'),
            'name' => 'category_id',
            'required' => true,
            'values' => $catgoryList,
        ));
        $model->setCategoryId($categoryIds);


        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('artists')->__('Status'),
            'name' => 'status',
            'required' => true,
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('artists')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('artists')->__('Disabled'),
                ),
            ),
        ));

        $fieldset->addField('biography', 'editor', array(
            'name' => 'biography',
            'style' => 'height:20em;width:36em',
            'required' => true,
            'label' => Mage::helper('artists')->__('Biography'),
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
