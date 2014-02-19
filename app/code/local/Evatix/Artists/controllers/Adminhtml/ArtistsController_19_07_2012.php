<?php

/**
 * @author  Md. Jahangir Alam <jahangir@evatix.com>
 * Artisrt Information
 * @copyright evatix.com all right reserve <http://www.evatix.com>
 */
class Evatix_Artists_Adminhtml_ArtistsController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('artists/artists')
                ->_addBreadcrumb(Mage::helper('artists')->__('Artists'), Mage::helper('artists')->__('Artists'))
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Artists'), Mage::helper('adminhtml')->__('Manage Artists'));
        return $this;
    }

    public function indexAction() {
        $this->_title($this->__('Artists'))->_title($this->__('Manage Artists'));
        $this->_initAction()
                ->renderLayout();
    }

    /**
     * Image List Module
     */
    public function imagesAction() {
        $imagePanel .="<div class=\"entry-edit\">
                        <div class=\"entry-edit-head\">
                            <h4 class=\"icon-head head-edit-form fieldset-legend\">Images</h4>
                        </div>
                        <div class=\"fieldset\" id=\"image_fieldset\">";

        $imagePanel .= "<table id=\"image_list\">";

        $id = $this->getRequest()->getParam('id', 0);
        $tableName = Mage::getSingleton('core/resource')->getTableName('artists_image');
        $readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql = "SELECT * FROM " . $tableName . " WHERE artists_id=" . $id;
        $result = array();
        try {
            $result = $readConnection->fetchAll($sql);
        } catch (Excepion $ex) {

        }

        $lastIndex = 1;

        if ($id && $result) {
            foreach ($result as $key => $value) {
                $lastIndex = $value['unique_index'];
                $imagePanel .= "<tr>";
                $imagePanel .= "<td>";
                $imagePanel .= "<input type=\"file\" name=\"images" . $lastIndex . "\" />";
                $imagePanel .= "<input type=\"hidden\" name=\"index[" . $lastIndex . "]\" value=\"" . $lastIndex . "\" />";
                $imagePanel .= "<input type=\"button\" onclick=\"removeRow(this, 'image_list')\" value=\"Del Row\" />";
                $imagePanel .= '<img src="' . Mage::getBaseUrl('media') . 'artists/' . $value['image'] . '" width="63" height="63" alt="Artist Image" />';
                $imagePanel .= "</td>";
                $imagePanel .= "</tr>";
                
            }
        } else {
            $imagePanel .= "<tr>";
            $imagePanel .= "<td>";
            $imagePanel .= "<input type=\"file\" name=\"images" . $lastIndex . "\" />
                            <input type=\"hidden\" name=\"index[" . $lastIndex . "]\" value=\"" . $lastIndex . "\" />
                            <input type=\"button\" onclick=\"removeRow(this, 'image_list')\" value=\"Del Row\" />";
            $imagePanel .= "</td>";
            $imagePanel .= "</tr>";
        }

        $imagePanel .= "</table>
                        <input type=\"hidden\" id=\"lastindex\" value=\"" . $lastIndex . "\" />
                        <input type=\"button\" onclick=\"insRow('image_list')\" value=\"Add Row\" />
                        </div></div>";
        echo $imagePanel;
    }

    /**
     * Edit
     */
    public function editAction() {
        $this->_title($this->__('Manage Artists'));
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('artists/artists')->load($id);
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('artists', $model);
            $this->_initAction()
                    ->_addBreadcrumb(
                            $id ? Mage::helper('artists')->__('Edit Artists') : Mage::helper('artists')->__('Edit Artists'),
                            $id ? Mage::helper('artists')->__('Edit Artists') : Mage::helper('artists')->__('Edit Artists')
            );

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('artists/adminhtml_artists_edit'))
                    ->_addLeft($this->getLayout()->createBlock('artists/adminhtml_artists_edit_tabs'));
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
     *
     * @param array $data
     * @return bool
     */
    private function _validatePostData(&$data = array()) {
        $data['title'] = strip_tags($data['title']);
        $data['category_id'] = intval($data['category_id']);
        $error = array();
        if (empty($data['title'])) {
            $this->_getSession()->addError('Please enter title');
            return false;
        }

        if (empty($data['biography'])) {
            $this->_getSession()->addError('Please enter biography');
            return false;
        }

        if (empty($data['category_id'])) {
            $this->_getSession()->addError('Please select category');
            return false;
        }
        return true;
    }

    /**
     * Upload Image
     * @param   $artistId int|integer
     * @return  bool|boolean
     */
    private function uploadImage($artistId = 0) {
        if ($_FILES && $artistId) {
            try {
                $path = Mage::getBaseDir('media') . DS . 'artists' . DS;
                $tableName = Mage::getSingleton('core/resource')->getTableName('artists_image');
                $writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write');
                $index = $this->getRequest()->getPost('index');

                /** Delete Image * */
                try {
                    $indexArray = array_keys($index);
                    $indexList = implode(',', $indexArray);
                    $query = 'DELETE FROM ' . $tableName . ' WHERE unique_index NOT IN(' . $indexList . ')';
                    $writeConnection->query($query);
                } catch (Exception $ex) {                
                }

                foreach ($_FILES as $key => $value) {
                    $fname = $value['name'];
                    if ($fname) {
                        $uploader = new Varien_File_Uploader($key);
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                        $uploader->setAllowCreateFolders(true);
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        /** Generate Index * */
                        $imageIndex = intval(str_replace('images', '', $key));
                        /** save Image * */
                        $uploader->save($path, $fname);

                        try {
                            $data['artists_id'] = $artistId;
                            $data['image'] = $fname;
                            $data['unique_index'] = $index[$imageIndex];
                            $data['upimage'] = $fname;

                            /** Prepared Statement **/
                            $query = "INSERT INTO " . $tableName . " (artists_id,image,unique_index)
                                      VALUES (:artists_id,:image,:unique_index)
                                      ON DUPLICATE KEY UPDATE image=:upimage";
                            
                            $writeConnection->query($query, $data);
                        } catch (Exception $ex) {
                            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
                        }
                    }
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
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
                    $model = Mage::getModel('artists/artists');
                    $model->setData($data);
                    if ($id) {
                        $model->setId($id);
                    }
                    $model->save();
                    $artistId = $model->getId();
                     
                    /** Upload Artist Photo **/
                    $this->uploadImage($artistId);

                    $collection = Mage::getModel('artists/configaration')->getCollection();
                    $configaration = $collection->getData();
                    if ($configaration) {
                        $configData = array_pop($configaration);
                        $defaultTitle = Mage::getStoreConfig('design/head/default_title');
                        $mail = new Zend_Mail();
                        $mail->setBodyHtml($configData['email_template']);
                        $mail->setFrom($configData['admin_email'], $defaultTitle);
                        $mail->addTo($data['email_address'], $data['name']);
                        $mail->setSubject($configData['page_title']);
                        $mail->send();
                    }
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('artists')->__('Save successfully.'));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);

                    if ($this->getRequest()->getParam('back')) {
                        $this->_redirect('*/*/edit', array('id' => $artistId));
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
                Mage::getModel('artists/artists')->setId($id)->delete();
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
                    $artists = Mage::getModel('artists/artists')->load($id);
                    $artists->delete();
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
                    $model = Mage::getModel('artists/artists')->load($id);
                    $model->setStatus($this->getRequest()->getParam('status'))
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
