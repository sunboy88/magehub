<?php

/**
 * Product in Cms Page For Product
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Evatix_Artists_Block_Adminhtml_Featured_Edit_Tab_Artist extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Set grid params
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('featured_artists_grid');
        $this->setDefaultSort('artists_id');
        $this->setUseAjax(true);
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return Evatix_Artists_Block_Adminhtml_Featured_Edit_Tab_Artist
     */
    protected function _addColumnFilterToCollection($column) {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_artists') {
            $artistIds = $this->_getSelectedArtists();
            if (empty($artistIds)) {
                $artistIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('artists_id', array('in' => $artistIds));
            } else {
                if($artistIds) {
                    $this->getCollection()->addFieldToFilter('artists_id', array('nin' => $artistIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection() {
        $collection = Mage::getModel('artists/artists')->getCollection();

        $tableName = Mage::getSingleton('core/resource')->getTableName('artists_category');
        $collection->getSelect()->join(
                $tableName . ' AS art_cat',
                'main_table.category_id = art_cat.id',
                array('category_name')
        );
        $tableName = Mage::getSingleton('core/resource')->getTableName('featured_artists');
        $collection->getSelect()->joinLeft(
                $tableName . ' AS f_artist',
                'main_table.artists_id = f_artist.artists_id',
                array('position')
        );

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns() {
         $this->addColumn('in_artists', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'in_artists',
            'field_name' => 'in_artists[]',
            'values' => $this->_getSelectedArtists(),
            'align' => 'center',
            'index' => 'artists_id'
        ));

        $this->addColumn('artists_id', array(
            'header' => Mage::helper('artists')->__('ID'),
            'sortable' => true,
            'width' => 60,
            'index' => 'artists_id'
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('artists')->__('Title'),
            'index' => 'title',
            'sortable' => true,
        ));

        $this->addColumn('category_name', array(
            'header' => Mage::helper('artists')->__('Category'),
            'width' => 100,
            'index' => 'category_name',
            'sortable' => true,
        ));

        $this->addColumn('image', array(
            'header' => Mage::helper('artists')->__('Image'),
            'align' => 'left',
            'index' => 'image'
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('artists')->__('Status'),
            'width' => 90,
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getSingleton('artists/status')->getOptionArray(),
            'sortable' => true,
        ));

        /*
        $this->addColumn('position', array(
            'header' => Mage::helper('catalog')->__('Position'),
            'name' => 'position',
            'type' => 'number',
            'validate_class' => 'validate-number',
            'index' => 'position',
            'width' => 60,
            'editable' => true
        ));
        */
        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('*/*/artist', array('_current' => true));
    }

    /**
     * Retrieve selected artists
     *
     * @return array
     */
    protected function _getSelectedArtists() {
        $artistList = $this->getSelectedArtists();
        if (is_array($artistList)) {
            $artistList = array_keys($artistList);
        }
        return $artistList;
    }

    /**
     * Retrieve Selected Artists
     *
     * @return array
     */
    public function getSelectedArtists() {
        $artistList = array();
        $tableName = Mage::getSingleton('core/resource')->getTableName('featured_artists');
        $sql = "SELECT artists_id,position FROM " . $tableName;
        $readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');
        try {
            $result = $readConnection->fetchAll($sql);
            foreach ($result as $value) {
                $artistList[$value['artists_id']] = array('position' => $value['position']);
            }
        } catch (Exception $ex) {
            $artistList = array();
        }
        return $artistList;
    }


}

