<?php

class Evatix_Artists_Block_Adminhtml_Artists_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('artistsGrid');
        $this->setDefaultSort('artists_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('artists/artists')->getCollection();
        $tableName = Mage::getSingleton('core/resource')->getTableName('artists_category');
        $collection->getSelect()->join(
                $tableName . ' AS art_cat',
                'main_table.category_id = art_cat.id',
                array('category_name')
        );
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

        $this->addColumn('category_name', array(
            'header' => Mage::helper('artists')->__('Category'),
            'align' => 'left',
            'index' => 'category_name',
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

        $this->addColumn('created_date', array(
            'header' => Mage::helper('artists')->__('Created Date'),
            'align' => 'left',
            'index' => 'created_date'
        ));

        $this->addColumn('action',
                array(
                    'header' => Mage::helper('artists')->__('Action'),
                    'width' => '100',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => Mage::helper('artists')->__('Edit'),
                            'url' => array('base' => '*/*/edit'),
                            'field' => 'id'
                        )
                    ),
                    'filter' => false,
                    'sortable' => false,
                    'index' => 'stores',
                    'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('artists_id');
        $this->getMassactionBlock()->setFormFieldName('artists');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('artists')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('artists')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('artists/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('artists')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('artists')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
