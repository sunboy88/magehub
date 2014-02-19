<?php

/**
 * @author  Md. Jahangir Alam <jahangir@evatix.com>
 * Artisrt Information
 * @copyright evatix.com all right reserve <http://www.evatix.com>
 */
class Evatix_Artists_Adminhtml_FeaturedController extends Mage_Adminhtml_Controller_action {

    /**
     * Load Layout and Initialize Breadcrumb
     * @return Evatix_Artists_Adminhtml_FeaturedController
     */
    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('artists/artists')
                ->_addBreadcrumb(Mage::helper('artists')->__('Configaration'), Mage::helper('artists')->__('Configaration'));
        return $this;
    }

    /**
     * Default Action
     */
    public function indexAction() {
        $this->_title($this->__('Artists'))->_title($this->__('Configaration'));
        $this->_initAction()
                ->renderLayout();
    }

    /**
     * Edit
     */
    public function editAction() {
        $this->_title($this->__('Configaration'));
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('artists/configaration')->load($id);
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('configaration', $model);
            $this->_initAction()
                    ->_addBreadcrumb(
                            $id ? Mage::helper('artists')->__('Artists') : Mage::helper('artists')->__('Artists'),
                            $id ? Mage::helper('artists')->__('Configaration') : Mage::helper('artists')->__('Configaration')
            );

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('artists/adminhtml_featured_edit'))
                    ->_addLeft($this->getLayout()->createBlock('artists/adminhtml_featured_edit_tabs'));
            if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
                $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            }
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('This page no longer exists.'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    /**
     * Save Artist Information
     */
    public function saveAction() {
        $id = $this->getRequest()->getParam('id', 0);
        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('artists/configaration');
                $model->setData($data);
                if ($id) {
                    $model->setId($id);
                }
                $model->save();
                $saveId = $model->getId();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('artists')->__('Save Successfully.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $saveId));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('artists')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

}
