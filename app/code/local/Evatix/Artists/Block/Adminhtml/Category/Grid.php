<?php

/**
 * @author  Md. Jahangir Alam <jahangir@evatix.com>
 * Artisrt Category Grid
 * @copyright evatix.com allright reserve <http://www.evatix.com>
 */
class Evatix_Artists_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('categoryGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('artists/category')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('artists')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));

        $this->addColumn('category_name', array(
            'header' => Mage::helper('artists')->__('Name'),
            'align' => 'left',
            'index' => 'category_name',
        ));

        $this->addColumn('content', array(
            'header' => Mage::helper('artists')->__('Description'),
            'align' => 'left',
            'index' => 'content',
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

        /*
          $statuses = Mage::getSingleton('artists/status')->getOptionArray();

          array_unshift($statuses, array('label' => '', 'value' => ''));
          $this->getMassactionBlock()->addItem('status', array(
          'label' => Mage::helper('artists')->__('Change status'),
         */
        //    'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
        /*    'additional' => array(
          'visibility' => array(
          'name' => 'status',
          'type' => 'select',
          'class' => 'required-entry',
          'label' => Mage::helper('artists')->__('Status'),
          'values' => $statuses
          )
          )
          ));
         */
        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
