<?php

/**
 * Category Block
 * Show Artist List of Selected category
 */
class Evatix_Artists_Block_List extends Mage_Core_Block_Template {

     public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    /**
     * Get Artist Collection
     * @return object
     */
    
    public function getArtistList() {
        $id = intval(Mage::app()->getRequest()->getParam('id', 0));

        /** Set Category To register **/
        $artistCategory = Mage::getModel('artists/category')->getCollection();
        $artistCategory->getSelect()->where('main_table.id='.$id);
        if (!$artistCategory->count()) {
            Mage::getSingleton('customer/session')->addError(Mage::helper('artists')->__('Unable to find artist category'));
            return ;
        }
        Mage::register('artist_category', $artistCategory);
        /** End Set Category To register **/


        $collection = Mage::getModel('artists/artists')->getCollection();
        $coreResource = Mage::getSingleton('core/resource');

        $relTblName = $coreResource->getTableName('artists_category_rel');
        $collection->getSelect()->join(
                $relTblName . ' AS art_cat_rel',
                'main_table.artists_id = art_cat_rel.artists_id AND art_cat_rel.category_id='.$id
        );
        
        $artistImageTbl = $coreResource->getTableName('artists_image');
        $artistTbl = $coreResource->getTableName('artists');
        $collection->getSelect()->joinLeft(
                array('temp' => new Zend_Db_Expr('(SELECT DISTINCT(a_i.artists_id) AS artists_id, a_i.image FROM '.$artistTbl.' AS a
                INNER JOIN '.$artistImageTbl.' As a_i ON a_i.artists_id = a.artists_id GROUP BY a_i.artists_id )')),
                'temp.artists_id=main_table.artists_id',
                array('image'));
                
        $collection->getSelect()->where('main_table.status=1');
        $collection->getSelect()->order('main_table.title ASC');
        //echo '<pre />'; 
        //print_r($collection->getData()); exit;
        //var_dump((string)$collection->getSelect()); exit;
        return $collection;
    }

    /**
     *
     * @param int $artistId
     * @return  array
     */
    public function getArtistGallery($artistId = 0) {
        $coreResource = Mage::getSingleton('core/resource');
        $tableName = $coreResource->getTableName('artists_image');
        $readConn = $coreResource->getConnection('core_read');
        $sql = "SELECT * FROM ".$tableName." WHERE artists_id=".intval($artistId);
        $galleryList = array();
        try {
            $galleryList = $readConn->fetchAll($sql);
        } catch (Exception $ex) {
            $galleryList = array();
        }
        return $galleryList;
    }

}
