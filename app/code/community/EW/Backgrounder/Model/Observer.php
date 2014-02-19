<?php

class EW_Backgrounder_Model_Observer{


    public function cmsPagePrepareSave($observer){
		$_post = $observer->getRequest()->getPost();		
		if (!$_FILES['bg']){
			Mage::getSingleton('adminhtml/session')->addError('No file');
		}else{
			$files = $_FILES['bg'];			
			$dir = getcwd();
			$existCollection = Mage::getModel('backgrounder/backgrounds')->getCollection()
				->addFieldToFilter('obj_id',$observer->getPage()->getPageId())
				->addFieldToFilter('type',0);
			$imgs = array();	
			foreach($existCollection as $exist){
				if (!in_array($exist->getImage(),$_post['bgsv'])){
					$exist->delete();
				}else{
					$imgs[''.$exist->getImage().''] = true;		
				}	
					
			}			
			for ($index = 0; $index < sizeof($files['name']); $index++ ){								
				if ($files['error'][$index] == 0){
					if (!isset($imgs[''.$files['name'][$index].''])){
						if (!move_uploaded_file ($files['tmp_name'][$index], $dir.'/media/backgrounds/'.$files['name'][$index]))
								Mage::getSingleton('adminhtml/session')->addError('Error when upload file');
							else{
								$bg = Mage::getModel('backgrounder/backgrounds');
								$bg->setObjId($observer->getPage()->getPageId());
								$bg->setImage($files['name'][$index]);
								$bg->setType(0);
								try{$bg->save();}catch(Exception $e){print_r($e->getMessage());die;}
						}	
					}
					$imgs[''.$files['name'][$index].''] = true;	
				}else{
					//Mage::getSingleton('adminhtml/session')->addError('Error '.$files['error'][$index].'when upload file');
				}
							
			}
				 		
		}		
	}
	
	public function cmsPageRender($observer){
		Mage::unregister('current_page');
		Mage::register('current_page',$observer->getPage());
	}
	
	public function catProductRender($observer){
		$_post = $observer->getRequest()->getPost();	
		if (!$_FILES['bg']){
			Mage::getSingleton('adminhtml/session')->addError('No file');
		}else{
			$files = $_FILES['bg'];			
			$dir = getcwd();
			$existCollection = Mage::getModel('backgrounder/backgrounds')->getCollection()
				->addFieldToFilter('obj_id',$observer->getProduct()->getId())
				->addFieldToFilter('type',1);
			foreach($existCollection as $exist){
				if (!in_array($exist->getImage(),$_post['bgsv']))
					$exist->delete();
				else{
					$imgs[''.$exist->getImage().''] = true;		
				}		
			}	
			for ($index = 0; $index < sizeof($files['name']); $index++ ){				
				if ($files['error'][$index] == 0){		
					if (!isset($imgs[''.$files['name'][$index].''])){
						if (!move_uploaded_file ($files['tmp_name'][$index], $dir.'/media/backgrounds/'.$files['name'][$index]))
							Mage::getSingleton('adminhtml/session')->addError('Error when upload file');
						else{
							$bg = Mage::getModel('backgrounder/backgrounds');
							$bg->setObjId($observer->getProduct()->getId());
							$bg->setImage($files['name'][$index]);
							$bg->setType(1);
							try{$bg->save();}catch(Exception $e){print_r($e->getMessage());die;}
						}	
					}
					$imgs[''.$files['name'][$index].''] = true;	
				}else{
					//Mage::getSingleton('adminhtml/session')->addError('Error '.$files['error'][$index].'when upload file');
				}
				
			}
				 		
		}
		
	}
	
	public function catRender($observer){	
		$_post = $observer->getRequest()->getPost();	
		if (!$_FILES['bg']){
			Mage::getSingleton('adminhtml/session')->addError('No file');
		}else{
			$files = $_FILES['bg'];			
			$dir = getcwd();
			$existCollection = Mage::getModel('backgrounder/backgrounds')->getCollection()
				->addFieldToFilter('obj_id',$observer->getCategory()->getId())
				->addFieldToFilter('type',2);
			foreach($existCollection as $exist){
				if (!in_array($exist->getImage(),$_post['bgsv']))
					$exist->delete();
				else{
					$imgs[''.$exist->getImage().''] = true;		
				}		
			}	
			for ($index = 0; $index < sizeof($files['name']); $index++ ){				
				if ($files['error'][$index] == 0){
					if (!isset($imgs[''.$files['name'][$index].''])){
						if (!move_uploaded_file ($files['tmp_name'][$index], $dir.'/media/backgrounds/'.$files['name'][$index]))
							Mage::getSingleton('adminhtml/session')->addError('Error when upload file');
						else{
							$bg = Mage::getModel('backgrounder/backgrounds');
							$bg->setObjId($observer->getCategory()->getId());
							$bg->setImage($files['name'][$index]);
							$bg->setType(2);
							try{$bg->save();}catch(Exception $e){print_r($e->getMessage());die;}
						}
					}
					$imgs[''.$files['name'][$index].''] = true;						
				}else{
					//Mage::getSingleton('adminhtml/session')->addError('Error '.$files['error'][$index].'when upload file');
				}
				
			}
				 		
		}
		
	}
  

}


