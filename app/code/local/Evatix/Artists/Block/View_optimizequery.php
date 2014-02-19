<?php

class Evatix_Artists_Block_View extends Mage_Core_Block_Template {

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    /**
     * Get Artist Information By Artist Id
     * @return object
     */
    public function getArtistInformation() {
        $id = intval(Mage::app()->getRequest()->getParam('id', 0));
        $collection = Mage::getModel('artists/artists')->getCollection();
        $tableName = Mage::getSingleton('core/resource')->getTableName('artists_category');
        $collection->getSelect()->join(
                $tableName . ' AS art_cat',
                'main_table.category_id = art_cat.id',
                array('category_name')
        );
        $collection->getSelect()->where('main_table.status=1 AND main_table.artists_id=' . $id);
        return $collection;
    }

    /**
     * Get Artist Gallery Information
     * @param int $artistId
     * @return  array
     */
    public function getArtistGallery() {
        $id = intval(Mage::app()->getRequest()->getParam('id', 0));
        $tableName = Mage::getSingleton('core/resource')->getTableName('artists_image');
        $readConn = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql = "SELECT * FROM " . $tableName . " WHERE artists_id=" . intval($id);
        $galleryList = array();
        try {
            $galleryList = $readConn->fetchAll($sql);
        } catch (Exception $ex) {
            $galleryList = array();
        }
        return $galleryList;
    }

}
