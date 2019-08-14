<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Block_Adminhtml_Topnavigation_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('topnavigation_Grid');
        // This is the primary key of the database
        $this->setDefaultSort('sort_order');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    { 
        $collection = Mage::getModel('topnavigation/topnavigation')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('topnavigation_id', array(
            'header'    => Mage::helper('topnavigation')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'menu_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('topnavigation')->__('Front-end label'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        $this->addColumn('content_type', array(
            'header'    => Mage::helper('topnavigation')->__('Content Type'),
            'align'     =>'left',
            'index'     => 'content_type',
            'type'      => 'options',
            'options'   => array(
                1 => 'Anchor Text',
                2 => 'Product Listing',
                3 => 'Content',
                4 => 'Category Listing',
            ),
        ));
        
        $this->addColumn('link', array(
            'header'    => Mage::helper('topnavigation')->__('URL'),
            'width'     => '150px',
            'index'     => 'link',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('topnavigation')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));
      
        $this->addColumn('sort_order', array(        
            'header'    => Mage::helper('topnavigation')->__('Sort order'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'sort_order',
        ));        
        

        return parent::_prepareColumns();
    }
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('menu_id'); 
		$this->getMassactionBlock()->setFormFieldName('menuitem_id'); 
		$this->getMassactionBlock()->addItem('Delete', array(
			 'label'    => Mage::helper('topnavigation')->__('Delete'),
			 'url'      => $this->getUrl('*/*/massDelete'),
			 'confirm'  => Mage::helper('topnavigation')->__('Are you sure?')
		));
        $statuses = Mage::getSingleton('topnavigation/status')->getOptionArray();
        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('topnavigation')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('topnavigation')->__('Change Status'),
                         'values' => $statuses
                     )
             )
        ));
		return $this;
	}
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }


}
