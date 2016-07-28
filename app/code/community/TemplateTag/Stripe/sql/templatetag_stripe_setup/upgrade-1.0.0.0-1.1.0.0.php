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

/** @var $this TemplateTag_Stripe_Model_Resource_Setup */
$installer = $this;

Mage::getModel('widget/widget_instance')
    ->setType('stripe/poweredby')
    ->setPackageTheme('default/default')
    ->setTitle('Powered by Stripe')
    ->setStoreIds(array(0))
    ->setWidgetParameters(array(
        'style' => 'glossy',
    ))
    ->setSortOrder(0)
    ->setPageGroups(array(array(
        'page_group' => 'all_pages',
        'all_pages' => array(
            'layout_handle' => 'default',
            'for' => 'all',
            'block' => 'right'
        )
    )))
    ->save();
