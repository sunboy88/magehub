<?php

/**
 * Category Block
 * Show Artist List of Selected category
 */
class Evatix_Artists_Block_Category extends Mage_Core_Block_Template {

     public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    /**
     * Get Artist Collection
     * @return object
     */
    
    public function getArtistList() {
        $id = intval(Mage::app()->getRequest()->getParam('id', 0));
        $collection = Mage::getModel('artists/artists')->getCollection();
        $coreResource = Mage::getSingleton('core/resource');
        $tableName = $coreResource->getTableName('artists_category');
        if ($id) {
            $collection->getSelect()->join(
                $tableName . ' AS art_cat',
                'main_table.category_id = art_cat.id AND art_cat.id='.$id,
                array('category_name')
            );
        } else {
            $collection->getSelect()->join(
                $tableName . ' AS art_cat',
                'main_table.category_id = art_cat.id',
                array('category_name')
            );
        }

        $artistImageTbl = $coreResource->getTableName('artists_image');
        $artistTbl = $coreResource->getTableName('artists');
        $collection->getSelect()->joinLeft(
                array('temp' => new Zend_Db_Expr('(SELECT DISTINCT(a_i.artists_id) AS artists_id, a_i.image FROM '.$artistTbl.' AS a
                INNER JOIN '.$artistImageTbl.' As a_i ON a_i.artists_id = a.artists_id
                ORDER BY a_i.unique_index ASC)')),
                'temp.artists_id=main_table.artists_id',
                array('image'));
                
        $collection->getSelect()->where('main_table.status=1');
        //var_dump((string)$collection->getSelect()); exit;
        //echo '<pre />';
        //print_r($collection->getData()); exit;
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
