<?php

class Evatix_Banner_Adminhtml_SliderController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('banner/slider')
                ->_addBreadcrumb(Mage::helper('banner')->__('Slider'), Mage::helper('banner')->__('Slider'))
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Slider'), Mage::helper('adminhtml')->__('Manage Slider'));

        return $this;
    }

    public function indexAction() {
        $this->_title($this->__('Slider'))->_title($this->__('Manage Slider'));
        $this->_initAction()
                ->renderLayout();
    }

    public function imagesAction() {
        $id = $this->getRequest()->getParam('id', 0);
        $model = Mage::getModel('banner/slider')->load($id);
        $banner = $model->getData();
        $imagePanel .="<div class=\"entry-edit\">
                        <div class=\"entry-edit-head\">
                            <h4 class=\"icon-head head-edit-form fieldset-legend\">Images</h4>
                        </div>
                        <div class=\"fieldset\" id=\"image_fieldset\">";

        $imagePanel .= "<table id=\"image_list\">";
        $imagePanel .= "<tr>";
        $imagePanel .= "<td>";
        if ($banner) {
            $imagePanel .= "<input type=\"file\" name=\"image\" />";
            $imagePanel .= '<img src="' . Mage::getBaseUrl('media') . 'slider/' . $banner['image'] . '" width="63" height="63" alt="Slider" />';
        } else {
            $imagePanel .= "<input type=\"file\" name=\"image\" class=\"input-text required-entry\" />";
        }

        $imagePanel .= "</td>";
        $imagePanel .= "</tr>";
        $imagePanel .= "</table></div></div>";
        echo $imagePanel;
    }

    public function editAction() {

        $this->_title($this->__('Slider'))
                ->_title($this->__('Slider'))
                ->_title($this->__('Manage Slider'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('banner/slider')->load($id);

        // 2. Initial checking
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            $this->_title($model->getId() ? $model->getTitle() : $this->__('Add New Banner'));

            // 4. Register model to use later in blocks
            Mage::register('slider_data', $model);

            // 5. Build edit form
            $this->_initAction()
                    ->_addBreadcrumb(
                            $id ? Mage::helper('banner')->__('Edit Slider') : Mage::helper('cms')->__('Add New Slider'),
                            $id ? Mage::helper('banner')->__('Edit Slider') : Mage::helper('cms')->__('Add New Slider'));

            //6. Load Editor
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('banner/adminhtml_slider_edit'))
                    ->_addLeft($this->getLayout()->createBlock('banner/adminhtml_slider_edit_tabs'));

            if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
                $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            }

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('This page no longer exists.'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }


    public function saveAction() {
        $id = $this->getRequest()->getParam('id', 0);
        if ($data = $this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            try {
                $model = Mage::getModel('banner/slider');
                $fname = '';
                $fname = $_FILES['image']['name'];
                if ($_FILES && $fname) {
                    /** Upload Image **/
                    $path = Mage::getBaseDir('media') . DS . 'slider' . DS;
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowCreateFolders(true);
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $uploader->save($path, $fname);
                    $data['image'] = $fname;
               }
               if (!$id && $fname == '') {
                   Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Please select image'));
                   $this->_redirect('*/*/edit');
               }
                
                
                $model->setData($data);
                if ($id) {
                    $model->setId($id);
                }
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('Save successfully.'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('web')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $id = $this->getRequest()->getParam('id');
                Mage::getModel('banner/slider')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The page has been deleted.'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $bannerIds = $this->getRequest()->getParam('web');
        if (!is_array($pageIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannerIds as $id) {
                    $banner = Mage::getModel('banner/slider')->load($id);
                    $banner->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($bannerIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $bannerIds = $this->getRequest()->getParam('web');
        if (!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {

                foreach ($bannerIds as $id) {
                    $banner = Mage::getModel('banner/slider')->load($id);
                    $banner->setIsActive($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($banner))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }


}
