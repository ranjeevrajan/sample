<?php
/**
 * Template Tag
 *
 * @category   TemplateTag
 * @package    TemplateTag_Stripe
 * @copyright  Copyright (c) 2013 Template Tag Ltd. (https://www.templatetag.com)
 * @license    https://www.templatetag.com/legal/end-user-licence-agreement/ (Template Tag EULA)
 * @author     Leon Smith <leon@templatetag.com>
 */
class TemplateTag_Stripe_Model_System_Config_Source_Poweredby_Styles
{
    /**
     * System config options for the different powered by stripe buttons
     *
     * @return array
     */
    public function toOptionArray()
    {
        $helper = Mage::helper('stripe');
        return array(
            array('value' => 'glossy', 'label'=> $helper->__('Glossy')),
            array('value' => 'black-outline', 'label'=> $helper->__('Black Outline')),
            array('value' => 'black-solid', 'label'=> $helper->__('Black Solid')),
            array('value' => 'white-outline', 'label'=> $helper->__('White Outline')),
            array('value' => 'white-solid', 'label'=> $helper->__('White Solid')),
        );
    }
}
