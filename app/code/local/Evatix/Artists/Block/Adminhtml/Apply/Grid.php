<?php

/**
 * @author  Md. Jahangir Alam <jahangir@evatix.com>
 * Apply Artist Information
 * @copyright evatix.com allright reserve <http://www.evatix.com>
 */
class Evatix_Artists_Block_Adminhtml_Apply_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('applyartistGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('artists/apply')->getCollection();
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

        $this->addColumn('contact_name', array(
            'header' => Mage::helper('artists')->__('Conatact Name'),
            'align' => 'left',
            'index' => 'contact_name',
        ));

        $this->addColumn('contact_email', array(
            'header' => Mage::helper('artists')->__('Contact Email'),
            'align' => 'left',
            'index' => 'contact_email',
        ));

        $this->addColumn('address', array(
            'header' => Mage::helper('artists')->__('Address'),
            'align' => 'left',
            'index' => 'address',
        ));

        $this->addColumn('city', array(
            'header' => Mage::helper('artists')->__('City'),
            'align' => 'left',
            'index' => 'city',
        ));

        $this->addColumn('state', array(
            'header' => Mage::helper('artists')->__('State'),
            'align' => 'left',
            'index' => 'state',
        ));
        $this->addColumn('phone', array(
            'header' => Mage::helper('artists')->__('Phone'),
            'align' => 'left',
            'index' => 'phone',
        ));

        $this->addColumn('band', array(
            'header' => Mage::helper('artists')->__('Band'),
            'align' => 'left',
            'index' => 'band',
        ));

        $this->addColumn('action',
                array(
                    'header' => Mage::helper('artists')->__('Action'),
                    'width' => '100',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => Mage::helper('artists')->__('Preview'),
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
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('artists');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('artists')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('artists')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
