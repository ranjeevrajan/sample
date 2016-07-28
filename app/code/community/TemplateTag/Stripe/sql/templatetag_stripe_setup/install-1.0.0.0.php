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
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('sales/quote_payment'), 'stripe_test', array(
    'type'    => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
    'comment' => 'Stripe Test Mode',
));
$installer->getConnection()->addColumn($installer->getTable('sales/quote_payment'), 'stripe_token', array(
    'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment' => 'Stripe Token',
    'length'  => '255'
));

$installer->getConnection()->addColumn($installer->getTable('sales/order_payment'), 'stripe_test', array(
    'type'    => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
    'comment' => 'Stripe Test Mode',
));
$installer->getConnection()->addColumn($installer->getTable('sales/order_payment'), 'stripe_token', array(
    'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment' => 'Stripe Token',
    'length'  => '255'
));

$installer->endSetup();
