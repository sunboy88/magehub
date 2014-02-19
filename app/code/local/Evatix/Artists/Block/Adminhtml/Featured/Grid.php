<?php

/**
 * @author  Md. Jahangir Alam <jahangir@evatix.com>
 * Featured Artisrt Grid
 * @copyright evatix.com allright reserve <http://www.evatix.com>
 */
class Evatix_Artists_Block_Adminhtml_Featured_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('configarationGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('artists/configaration')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('artists')->__('ID'),
            'align' => 'left',
            'width' => '50px',
            'index' => 'id',
        ));

        $this->addColumn('page_title', array(
            'header' => Mage::helper('artists')->__('Page Title'),
            'align' => 'left',
            'index' => 'page_title',
        ));

        $this->addColumn('admin_email', array(
            'header' => Mage::helper('artists')->__('Admin Email Address'),
            'align' => 'left',
            'index' => 'admin_email',
        ));

        $this->addColumn('short_description', array(
            'header' => Mage::helper('artists')->__('Description'),
            'align' => 'left',
            'index' => 'short_description',
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
    /*
    protected function _prepareMassaction() {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('artists');
        return $this;
    }
    */
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
