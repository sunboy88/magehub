<?php

class Evatix_Artists_IndexController extends Mage_Core_Controller_Front_Action {

    /**
     * Show Artist List based on a Artist Category
     */
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function listAction() {
        $id = $this->getRequest()->getParam('id', 0);
        if (!$id) {
            Mage::getSingleton('customer/session')->addError(Mage::helper('artists')->__('Unable to find artist category'));
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Show Featured Artist List
     */
    public function featuredAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Show Featured Artist List
     */
    public function applyAction() {
        $this->loadLayout();
        /** For Calander * */
        $blockCal = $this->getLayout()->createBlock(
                        'Mage_Core_Block_Html_Calendar',
                        'html_calendar',
                        array('template' => 'page/js/calendar.phtml')
        );
        $this->getLayout()->getBlock('content')->append($blockCal);

        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        
        /** For Calander * */
        $this->getLayout()->getBlock('artist_apply')
                ->setFormAction(Mage::getUrl('*/*/post'));
        $this->renderLayout();
    }

    protected function _sendEmail($data = array()) {
        try {
            $model = Mage::getModel('artists/configaration')->getCollection();
            $configInfo = $model->getData();
            
            $leftsideanel = '<!--@styles
                                body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }
                            @-->
                            <body style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
                                <div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
                            ';
            $leftsideanel .= '<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
                                <tr>
                                    <td align="center" valign="top" style="padding:20px 0 20px 0">
                                        <table bgcolor="FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
                                            <tr>
                                                <td valign="top">
                                                    <h1 style="font-size:22px; font-weight:normal; line-height:22px; margin:0 0 11px 0;">
                                                        Applied Artist Information
                                                    </h1>
                                                 </td>
                                          </tr>
                                          <tr>
                                            <td>
                                                <table cellspacing="0" cellpadding="0" border="0" width="650">';
            if ($data) {
                $leftsideanel .= "<tr><th>Name : </th><td>".$data['contact_name']."</td></tr>";
                $leftsideanel .= "<tr><th>Address :</th><td>".$data['address']."</td></tr>";
                $leftsideanel .= "<tr><th>City :</th><td>".$data['city']."</td></tr>";
                $leftsideanel .= "<tr><th>State :</th><td>".$data['state']."</td></tr>";
                $leftsideanel .= "<tr><th>Zip/Postal Code :</th><td>".$data['zip_code']."</td></tr>";
                $leftsideanel .= "<tr><th>Phone :</th><td>".$data['phone']."</td></tr>";
                $leftsideanel .= "<tr><th>Email Address :</th><td>".$data['contact_email']."</td></tr>";
                $leftsideanel .= "<tr><th>Band Name :</th><td>".$data['band']."</td></tr>";
                $leftsideanel .= "<tr><th>Web Site :</th><td>".$data['website']."</td></tr>";
                $leftsideanel .= "<tr><th>Years w/band :</th><td>".$data['years']."</td></tr>";
                $leftsideanel .= "<tr><th>Other Bands :</th><td>".$data['band2']."</td></tr>";
                $leftsideanel .= "<tr><th>Upcoming Tour Dates :</th><td>".$data['tours']."</td></tr>";
                $leftsideanel .= "<tr><th>Upcoming TV Dates :</th><td>".$data['tv']."</td></tr>";
                $leftsideanel .= "<tr><th>Videos in Rotation :</th><td>".$data['video']."</td></tr>";
                
                $leftsideanel .= "<tr><th>Record Label :</th><td>".$data['record']."</td></tr>";
                $leftsideanel .= "<tr><th>Contact Person :</th><td>".$data['labelcontact']."</td></tr>";
                $leftsideanel .= "<tr><th>Phone :</th><td>".$data['labelphone']."</td></tr>";
                $leftsideanel .= "<tr><th>Web Site :</th><td>".$data['labelsite']."</td></tr>";
                $leftsideanel .= "<tr><th>Current Record :</th><td>".$data['current']."</td></tr>";
                $leftsideanel .= "<tr><th>Release Date :</th><td>".$data['release']."</td></tr>";
                $leftsideanel .= "<tr><th>Copies Sold :</th><td>".$data['sold']."</td></tr>";
                $leftsideanel .= "<tr><th>Previous Records :</th><td>".$data['previous']."</td></tr>";
                
                $leftsideanel .= "<tr><th>Management :</th><td>".$data['management']."</td></tr>";
                $leftsideanel .= "<tr><th>Contact Person :</th><td>".$data['managementperson']."</td></tr>";
                $leftsideanel .= "<tr><th>Phone :</th><td>".$data['managementcontact']."</td></tr>";
                $leftsideanel .= "<tr><th>Web Site :</th><td>".$data['managementwebsite']."</td></tr>";
                $leftsideanel .= "<tr><th>Referred by :</th><td>".$data['referred']."</td></tr>";
                $leftsideanel .= "<tr><th>Cymbals you currently play :</th><td>".$data['drum']."</td></tr>";
                $leftsideanel .= "<tr><th>Under Contract?</th><td>".$data['contract']."</td></tr>";
                $leftsideanel .= "<tr><th>If Yes, describe your relationship/deal :</th><td> ".$data['deal']."</td></tr>";
                $leftsideanel .= "<tr><th>Describe your preferred cymbal setup :</th><td> ".$data['drumkit']."</td></tr>";
                $leftsideanel .= "<tr><th>List other endorsements you have (include contact person and phone number) :</th><td> ".$data['comments']."</td></tr>";            
            } else {
               $leftsideanel .= "<tr><th>--No Data Found--</th></tr>";
            }
            $leftsideanel .= '</table></td></tr></table></td></tr></table>';     
            $leftsideanel .= '</div></body>';        
            
            if ($configInfo) {
                $mail = new Zend_Mail();
                $mail->setBodyHtml($leftsideanel);
                $mail->setFrom($data['contact_email'], $data['contact_name']);
                $mail->addTo($configInfo[0]['admin_email'], '');
                $mail->setSubject($configInfo[0]['page_title']);
                $mail->send();
            }
        } catch (Exception $ex) {
            
        }
        return true;
    }

    public function postAction() {
        $post = $this->getRequest()->getPost();
        
        if ($post) {
            /** Filter Post data * */
            $this->filterPostData($post);
            /** Process Filter Data For Validation * */
            $data = $this->processPostData($post);

            if ($this->validatePostData($data)) {
                 Mage::getSingleton('customer/session')->addError(Mage::helper('artists')->__('Please enter valid data'));
                 return;
            }

            try {
                /** Save Apply Information * */
                $model = Mage::getModel('artists/apply');
                $model->setData($data);
                if ($model->save()) {
                    $this->_sendEmail($data);
                }

                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('artists')->__('Thanks for your submission.'));
                $this->_redirect('*/*/apply');
                return;
            } catch (Exception $ex) {
                Mage::getSingleton('customer/session')->addError(Mage::helper('artists')->__('Unable to submit your request. Please, try again later'));
                $this->_redirect('*/*/apply');
                return;
            }
        } else {
            $this->_redirect('*/*/apply');
        }
    }

    /**
     * Filter Post Data
     * @param array $post
     * @return  void
     */
    private function filterPostData(&$post = array()) {
        foreach ($post as $key => $value) {
            $post[$key] = trim(strip_tags($value));
        }
    }

    /**
     * Process Post data from Apply form for save
     * @param   array $post
     * @return  array $data
     */
    private function processPostData($post = array()) {
        $data = array(
            'contact_name' => $post['contact-name'],
            'address' => $post['address'],
            'city' => $post['city'],
            'state' => $post['state'],
            'zip_code' => $post['zip_code'],
            'phone' => $post['phone'],
            'contact_email' => $post['contact-email'],
            'band' => $post['band'],
            'website' => $post['website'],
            'years' => intval($post['years']),
            'band2' => $post['band2'],
            'tours' => $post['tours'],
            'tv' => $post['tv'],
            'video' => $post['video'],
            'record' => $post['record'],
            'labelcontact' => $post['labelcontact'],
            'labelphone' => $post['labelphone'],
            'labelsite' => $post['labelsite'],
            'current' => $post['current'],
            'release' => $post['release'],
            'sold' => intval($post['sold']),
            'previous' => $post['previous'],
            'management' => $post['management'],
            'managementperson' => $post['managementperson'],
            'managementcontact' => $post['managementcontact'],
            'managementwebsite' => $post['managementwebsite'],
            'referred' => $post['referred'],
            'drum' => $post['drum'],
            'contract' => $post['contract'],
            'deal' => $post['deal'],
            'drumkit' => $post['drumkit'],
            'comments' => $post['comments']
        );
        return $data;
    }

    /**
     * Validate Post
     * @param array $post
     * @return boolean
     */
    private function validatePostData($post = array()) {
        $requiredField = array(
            'contact_name', 'address', 'city', 'state',
            'phone', 'contact_email', 'band'
        );
        $error = false;
        foreach ($requiredField as $value) {
            if (!Zend_Validate::is($post[$value], 'NotEmpty')) {
                $error = true;
            }
        }

        if (!Zend_Validate::is($post['contact_email'], 'EmailAddress')) {
            $error = true;
        }
        return $error;
    }

    /**
     * Show Artist Details Information
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', 0);
        if (!$id) {
            Mage::getSingleton('customer/session')->addError(Mage::helper('artists')->__('Unable to find artist'));
        }
        $this->loadLayout();
        $this->renderLayout();
    }

}