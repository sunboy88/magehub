<?php



class EW_Backgrounder_Model_Backgrounds extends Mage_Core_Model_Abstract{

    
    protected function _construct(){
		$this->_init('backgrounder/backgrounds');    
    }
	
	public function loadByType($_data){
		$collection = $this->getCollection()->addFieldToFilter('type',$_data['type'])->addFieldToFilter('obj_id',$_data['id']);
		return $collection;		
	}
  

}

