<?php

/**
 * @author  Md. Jahangir Alam <jahangir@evatix.com>
 * Artisrt Information
 * @copyright evatix.com all right reserve <http://www.evatix.com>
 */
class Evatix_Artists_Adminhtml_FeaturedartistsController extends Mage_Adminhtml_Controller_action {

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
     * Mass Featured Artists
     */
    public function massFeaturedAction() {
        $artistIds = $this->getRequest()->getParam('artists');
        /*print_r($artistIds);
        exit();*/
        if (!is_array($artistIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                $resource = Mage::getSingleton('core/resource'); 
                $tableName = $resource->getTableName('featured_artists');
                $writeConnection = $resource->getConnection('core_write');
                
                foreach ($artistIds as $id) {
                    $query = 'INSERT IGNORE INTO ' . $tableName . ' (artists_id) VALUES (' . $id . ')';
                    $writeConnection->query($query);
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully featured', count($artistIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    /**
     * Mass Delete Featured Artists
     */
    public function massDeleteAction() {
        $artistIds = $this->getRequest()->getParam('artists');
        /*print_r($artistIds);
        exit();*/
        if (!is_array($artistIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                $resource = Mage::getSingleton('core/resource'); 
                $tableName = $resource->getTableName('featured_artists');
                $writeConnection = $resource->getConnection('core_write');
                
                foreach ($artistIds as $id) {
                    $query = 'DELETE FROM ' . $tableName . ' WHERE artists_id = '.$id;
                    $writeConnection->query($query);
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully unfeatured', count($artistIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}
