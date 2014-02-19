<?php

/**
 * @author  Md. Jahangir Alam <jahangir@evatix.com>
 * @date    July 04, 2012
 * Manage Artists Category
 * @copyright Evatix.com all right reserve. <http://www.evatix.com>
 */
class Evatix_Artists_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('artists/category')
                ->_addBreadcrumb(Mage::helper('artists')->__('Artists'), Mage::helper('artists')->__('Artists'))
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Artists Category'), Mage::helper('adminhtml')->__('Artists Category'));
        return $this;
    }

    public function indexAction() {
        $this->_title($this->__('Artists'))->_title($this->__('Artists Category'));
        $this->_initAction()
                ->renderLayout();
    }

    /**
     * Edit Artist Category Information
     * @param   void
     * @return  void
     */
    public function editAction() {

        $this->_title($this->__('Artists Category'));
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('artists/category')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('artists_category', $model);
            $this->_initAction()
                    ->_addBreadcrumb(
                            $id ? Mage::helper('artists')->__('Edit Artists') : Mage::helper('artists')->__('Edit Artists'),
                            $id ? Mage::helper('artists')->__('Edit Artists') : Mage::helper('artists')->__('Edit Artists')
            );

            $this->_addContent($this->getLayout()->createBlock('artists/adminhtml_category_edit'))
                    ->_addLeft($this->getLayout()->createBlock('artists/adminhtml_category_edit_tabs'));
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
     *
     * @param array $data
     * @return bool
     */
    private function _validatePostData(&$data = array()) {
        $data['category_name'] = strip_tags($data['category_name']);

        $error = array();
        if (empty($data['category_name'])) {
            $this->_getSession()->addError('Please enter category name');
            return false;
        }

        return true;
    }

    /**
     * Save Artist Information
     */
    public function saveAction() {
        $id = $this->getRequest()->getParam('id', 0);
        if ($data = $this->getRequest()->getPost()) {
            if ($this->_validatePostData($data)) {
                try {
                    $model = Mage::getModel('artists/category');
                    $path = Mage::getBaseDir('media') . DS . 'artists' . DS . 'category' . DS;
                    foreach ($_FILES as $key => $value) {
                        $fname = $value['name'];
                        if ($fname) {
                            $data[$key] = 'artists/category/'.$fname;
                            $uploader = new Varien_File_Uploader($key);
                            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                            $uploader->setAllowCreateFolders(true);
                            $uploader->setAllowRenameFiles(false);
                            $uploader->setFilesDispersion(false);
                            $uploader->save($path, $fname);
                        }  else {
                            if ($data[$key]['delete']) {
                                $data[$key] = NULL;
                            } else {
                                $data[$key] = $data[$key]['value'];
                            }
                        }
                    }
                    
                    $model->setData($data);
                    if ($id) {
                        $model->setId($id);
                    }
                    $model->save();

                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('artists')->__('Artist category has been saved.'));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);

                    if ($this->getRequest()->getParam('back')) {
                        $this->_redirect('*/*/edit', array('id' => $model->getId()));
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
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('artists')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Single Item Delete
     */
    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $id = $this->getRequest()->getParam('id');
                Mage::getModel('artists/category')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Deleted successfully.'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Mass Delete Change
     */
    public function massDeleteAction() {
        $artistIds = $this->getRequest()->getParam('artists');
        if (!is_array($artistIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($artistIds as $id) {
                    $model = Mage::getModel('artists/category')->load($id);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($artistIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Mass Status Change
     */
    public function massStatusAction() {
        $artistIds = $this->getRequest()->getParam('artists');
        if (!is_array($artistIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {

                foreach ($artistIds as $id) {
                    $model = Mage::getModel('artists/category')->load($id);
                    $model->setIsActive($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($artistIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}
