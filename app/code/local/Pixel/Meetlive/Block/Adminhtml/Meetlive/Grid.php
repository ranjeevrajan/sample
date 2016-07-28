<?php

class Pixel_Meetlive_Block_Adminhtml_Meetlive_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('meetliveGrid');
      $this->setDefaultSort('meetlive_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('meetlive/meetlive')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('meetlive_id', array(
          'header'    => Mage::helper('meetlive')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'meetlive_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('meetlive')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
      
      $this->addColumn('email', array(
          'header'    => Mage::helper('meetlive')->__('Email'),
          'align'     =>'left',
          'index'     => 'email',
      ));
      
      $this->addColumn('telephone', array(
          'header'    => Mage::helper('meetlive')->__('Telephone'),
          'align'     =>'left',
          'index'     => 'telephone',
      ));
      
      $this->addColumn('nearest_city', array(
          'header'    => Mage::helper('meetlive')->__('Nearest City'),
          'align'     =>'left',
          'index'     => 'nearest_city',
      ));
      
	  
	  $this->addColumn('day',
		array(
			'header'=> $this->__('Date Selection'),
			'align' =>'left',
			'width' => '100px',
			'index' => 'day',
			'type' => 'datetime',
			'frame_callback' => array( $this,'styleDate' )
		));
	  
      $this->addColumn('suitable_time', array(
          'header'    => Mage::helper('meetlive')->__('Suitable Time'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'suitable_time',
          'type'      => 'options',
          'options'   => array(
              'after_6pm' => 'After 6pm',
              '2_30_6pm' => '2:30 pm - 6 pm',
              '12pm_2_30pm' => '12 pm - 2:30 pm',
              '9am_12pm' => '9 am -12 pm'
          ),
      ));
	  
	  $this->addColumn('created_time', array(
          'header'    => Mage::helper('meetlive')->__('Created Time'),
          'align'     => 'left',
          'index'     => 'created_time'
          
      ));
      
	  $this->addColumn('update_time', array(
          'header'    => Mage::helper('meetlive')->__('Updated Time'),
          'align'     => 'left',
          'index'     => 'update_time'
          
      ));
	  
	  
      $this->addColumn('status', array(
          'header'    => Mage::helper('meetlive')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('meetlive')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('meetlive')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('meetlive')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('meetlive')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  
  public function styleDate( $value,$row,$column,$isExport )
{
  $locale = Mage::app()->getLocale();
  $date = $locale->date( $value, $locale->getDateFormat(), $locale->getLocaleCode(), false )->toString( $locale->getDateFormat() ) ;
  return $date;
}
  
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('meetlive_id');
        $this->getMassactionBlock()->setFormFieldName('meetlive');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('meetlive')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('meetlive')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('meetlive/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('meetlive')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('meetlive')->__('Status'),
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