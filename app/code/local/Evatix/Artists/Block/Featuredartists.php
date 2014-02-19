<?php

class Evatix_Artists_Block_Featuredartists extends Mage_Core_Block_Template {

    public function _prepareLayout() 
    {
        return parent::_prepareLayout();
    }

    public function getFeaturedArtistList() 
    {
        $collection = Mage::getModel('artists/artists')->getCollection();
        $coreResource = Mage::getSingleton('core/resource');

        $artistImageTbl = $coreResource->getTableName('artists_image');
        $featuredArtistTbl = $coreResource->getTableName('featured_artists');
        $artistTbl = $coreResource->getTableName('artists');
        
        /*$readConn = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql = "SELECT main_table.* FROM ".$artistTbl." as main_table
                INNER JOIN ".$featuredArtistTbl." As f_a ON f_a.artists_id = main_table.artists_id
                WHERE main_table.status = 1 ";
                
        $featuredList = array();
        try {
            $featuredList = $readConn->fetchAll($sql);
        } catch (Exception $ex) {
            $featuredList = array();
        }        */
        
        
        $collection->getSelect()->joinLeft(
                array('temp' => new Zend_Db_Expr('(SELECT DISTINCT(a_i.artists_id) AS artists_id, a_i.image FROM '.$artistTbl.' AS a
                INNER JOIN '.$artistImageTbl.' As a_i ON a_i.artists_id = a.artists_id GROUP BY a_i.artists_id )')),
                'temp.artists_id=main_table.artists_id',
                array('image'));        
        $collection->getSelect()->joinInner(
                $featuredArtistTbl . ' AS featured_artists',
                'main_table.artists_id = featured_artists.artists_id',
                array()
        );        
        $collection->getSelect()->where('main_table.status=1');
        $collection->getSelect()->order('main_table.title ASC');
        
        //echo '<pre />';
        //print_r($collection->getData()); exit;
        //var_dump((string)$collection->getSelect());
         
        return $collection;
    }
}
