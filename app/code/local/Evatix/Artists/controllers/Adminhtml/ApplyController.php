<?php

/**
 * @author  Md. Jahangir Alam <jahangir@evatix.com>
 * Apply Artisrt Information
 * @copyright evatix.com all right reserve <http://www.evatix.com>
 */
class Evatix_Artists_Adminhtml_ApplyController extends Mage_Adminhtml_Controller_action {

    /**
     * Load Layout and Initialize Breadcrumb
     * @return Evatix_Artists_Adminhtml_FeaturedController
     */
    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('artists/artists')
                ->_addBreadcrumb(Mage::helper('artists')->__('Apply Artist'), Mage::helper('artists')->__('Apply Artist'));
        return $this;
    }

    /**
     * Default Action
     */
    public function indexAction() {
        $this->_title($this->__('Artists'))->_title($this->__('Apply Artist'));
        $this->_initAction()
                ->renderLayout();
    }

    /**
     * Edit
     */
    public function editAction() {
        $this->_title($this->__('Applied Artists'));
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('artists/apply')->load($id);
        $this->_initAction();
        if ($model->getId() && $id) {
            
            Mage::register('artists_apply', $model);
            
            $this->_addContent($this->getLayout()->createBlock('artists/adminhtml_apply_edit'))
                    ->_addLeft($this->getLayout()->createBlock('artists/adminhtml_apply_edit_tabs'));
            
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('This page no longer exists.'));
            $this->_redirect('*/*/');
        }
    }
    
    public function previewAction() {
        $this->_title($this->__('Apply Artist'));
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('artists/apply')->load($id);
        $data = $model->getData();
        $leftsideanel .="<div class=\"entry-edit\">
                        <div class=\"entry-edit-head\">
                            <h4 class=\"icon-head head-edit-form fieldset-legend\">Applied Artist Information</h4>
                        </div>
                        <div class=\"fieldset\" id=\"image_fieldset\">";
        $leftsideanel .= "<table>";
        if ($data) {
            $leftsideanel .= "<tr><th>Name</th><td>".$data['contact_name']."</td></tr>";
            $leftsideanel .= "<tr><th>Address</th><td>".$data['address']."</td></tr>";
            $leftsideanel .= "<tr><th>City</th><td>".$data['city']."</td></tr>";
            $leftsideanel .= "<tr><th>State</th><td>".$data['state']."</td></tr>";
            $leftsideanel .= "<tr><th>Zip/Postal Code</th><td>".$data['zip_code']."</td></tr>";
            $leftsideanel .= "<tr><th>Phone</th><td>".$data['phone']."</td></tr>";
            $leftsideanel .= "<tr><th>Email Address</th><td>".$data['contact_email']."</td></tr>";
            $leftsideanel .= "<tr><th>Band Name</th><td>".$data['band']."</td></tr>";
            $leftsideanel .= "<tr><th>Web Site</th><td>".$data['website']."</td></tr>";
            $leftsideanel .= "<tr><th>Years w/band</th><td>".$data['years']."</td></tr>";
            $leftsideanel .= "<tr><th>Other Bands</th><td>".$data['band2']."</td></tr>";
            $leftsideanel .= "<tr><th>Upcoming Tour Dates</th><td>".$data['tours']."</td></tr>";
            $leftsideanel .= "<tr><th>Upcoming TV Dates</th><td>".$data['tv']."</td></tr>";
            $leftsideanel .= "<tr><th>Videos in Rotation</th><td>".$data['video']."</td></tr>";

            $leftsideanel .= "<tr><th>Record Label</th><td>".$data['record']."</td></tr>";
            $leftsideanel .= "<tr><th>Contact Person</th><td>".$data['labelcontact']."</td></tr>";
            $leftsideanel .= "<tr><th>Phone</th><td>".$data['labelphone']."</td></tr>";
            $leftsideanel .= "<tr><th>Web Site</th><td>".$data['labelsite']."</td></tr>";
            $leftsideanel .= "<tr><th>Current Record</th><td>".$data['current']."</td></tr>";
            $leftsideanel .= "<tr><th>Release Date</th><td>".$data['release']."</td></tr>";
            $leftsideanel .= "<tr><th>Copies Sold</th><td>".$data['sold']."</td></tr>";
            $leftsideanel .= "<tr><th>Previous Records</th><td>".$data['previous']."</td></tr>";
            
            $leftsideanel .= "<tr><th>Management</th><td>".$data['management']."</td></tr>";
            $leftsideanel .= "<tr><th>Contact Person</th><td>".$data['managementperson']."</td></tr>";
            $leftsideanel .= "<tr><th>Phone</th><td>".$data['managementcontact']."</td></tr>";
            $leftsideanel .= "<tr><th>Web Site</th><td>".$data['managementwebsite']."</td></tr>";
            $leftsideanel .= "<tr><th>Referred by</th><td>".$data['referred']."</td></tr>";
            $leftsideanel .= "<tr><th>Cymbals you currently play</th><td>".$data['drum']."</td></tr>";
            $leftsideanel .= "<tr><th>Under Contract?</th><td>".$data['contract']."</td></tr>";
            $leftsideanel .= "<tr><th>If Yes, describe your relationship/deal </th><td>".$data['deal']."</td></tr>";
            $leftsideanel .= "<tr><th>Describe your preferred cymbal setup </th><td>".$data['drumkit']."</td></tr>";
            $leftsideanel .= "<tr><th>List other endorsements you have (include contact person and phone number) </th><td>".$data['comments']."</td></tr>";
        } else {
            $leftsideanel .= "<tr><td colspn='2'>No Data Found </td></tr>";
        }
        $leftsideanel .= "</table></div></div>";
        echo $leftsideanel;
    }

    /**
     * Mass Delete Change
     */
    public function massDeleteAction() {
        $applyArtistIds = $this->getRequest()->getParam('artists');
        if (!is_array($applyArtistIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($applyArtistIds as $id) {
                    $artists = Mage::getModel('artists/apply')->load($id);
                    $artists->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($applyArtistIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}
