<?php    
class Offi_CustomerAttribute_Model_Resource_Eav_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup
{
 
	/**
	 * @return array
	 */
	public function getDefaultEntities()
	{
		return array(
			'quote' => array(
				'entity_model'  => 'sales/quote',
                'table'         => 'sales/quote',
				'attributes' => array(
                    'test_number' => array('type'=>'static'),
                ),
                    
            ),
		);
	}
}