<?php

class Evatix_Artists_Block_Adminhtml_Featuredartists_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('featuredartistsGrid');
        $this->setDefaultSort('artists_id');
        $this->setDefaultDir('ASC');
        //$this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('artists/artists')->getCollection();
        
        $tableName = Mage::getSingleton('core/resource')->getTableName('featured_artists');
        $collection->getSelect()->joinLeft(
                $tableName . ' AS featured_artists',
                'main_table.artists_id = featured_artists.artists_id',
                array(" (CASE WHEN IFNULL(featured_artists.artists_id, 0)=0 THEN 'No' ELSE 'Yes' END) as featured")
        );
        //var_dump((string)$collection->getSelect());
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('artists_id', array(
            'header' => Mage::helper('artists')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'artists_id',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('artists')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        
        $this->addColumn('featured', array(
            'header' => Mage::helper('artists')->__('Featured'),
            'align' => 'left',
            'index' => 'featured',
        ));
        
        $this->addColumn('status', array(
            'header' => Mage::helper('artists')->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                2 => Mage::helper('artists')->__('Disabled'),
                1 => Mage::helper('artists')->__('Enabled')
            ),
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('artists_id');
        $this->getMassactionBlock()->setFormFieldName('artists');

        $this->getMassactionBlock()->addItem('featured', array(
            'label' => Mage::helper('artists')->__('Featured'),
            'url' => $this->getUrl('*/*/massFeatured')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('artists')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete')
        ));

        
        return $this;
    }

}
