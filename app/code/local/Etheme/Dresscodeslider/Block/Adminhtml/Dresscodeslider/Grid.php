<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeslider_Block_Adminhtml_Dresscodeslider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('dresscodeslider');
      $this->setDefaultSort('slide_id');
      $this->setDefaultDir('desc');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('dresscodeslider/dresscodeslider')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('slide_id', array(
          'header'    => Mage::helper('dresscodeslider')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'slide_id',
      ));
	 

	  $this->addColumn('image', array(
          'header'    => Mage::helper('dresscodeslider')->__('Image 0'),
          'align'     =>'left',
          'index'     => 'image',
		  'renderer'  => 'dresscodeslider/renderer_image',
      ));

      $this->addColumn('image1', array(
          'header'    => Mage::helper('dresscodeslider')->__('Image 1'),
          'align'     =>'left',
          'index'     => 'image1',
		  'renderer'  => 'dresscodeslider/renderer_image',
      ));



      $this->addColumn('link', array(
          'header'    => Mage::helper('dresscodeslider')->__('Link Left'),
          'align'     =>'left',
          'index'     => 'link',
      ));

      $this->addColumn('link_1', array(
          'header'    => Mage::helper('dresscodeslider')->__('Link Right'),
          'align'     =>'left',
          'index'     => 'link_1',
      ));

	  $this->addColumn('status', array(
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(1 => 'Enabled', 2 => 'Disabled'),
          'header'    => Mage::helper('dresscodeslider')->__('Status'),
          'align'     => 'left',
          'width'     => '20px',
      ));
	  
      $this->addColumn('action',
            array(
                'header' => Mage::helper('catalog')->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('Edit'),
                        'url' => array(
                            'base'=>'*/*/edit',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
        ));

      return parent::_prepareColumns();
  }


  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}