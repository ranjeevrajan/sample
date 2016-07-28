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
class TemplateTag_Stripe_Model_Observer
{
    /**
     * Adds our custom javascript to the admin checkout screen
     *
     * This is needed because Mage_Adminhtml_Block_Page_Head does not call getChildHtml() in its
     * template and its easier and more future proof to use an observer to add the javascript rather
     * than redefining/overloading the template
     *
     * @param Varien_Event_Observer $observer
     */

    public function addJsToFrontendCheckout(Varien_Event_Observer $observer)
    {
        $targetBlock = Mage::getConfig()->getBlockClassName('checkout/onepage_payment');
        $block = $observer->getBlock();
        $blockClass = get_class($block);

        if (!Mage::Helper('stripe')->getActive()) { return; }
        if ($blockClass != $targetBlock) { return; }

        $transport = $observer->getTransport();
        $html = $transport->getHtml();
        $extra = $block->getLayout()
            ->createBlock('core/template')
            ->setTemplate('stripe/javascript.phtml')
            ->toHtml();
        $transport->setHtml($extra . $html);
    }

    public function addJsToAdminCheckout(Varien_Event_Observer $observer)
    {
        $targetBlock = Mage::getConfig()->getBlockClassName('adminhtml/page_head');
        $block = $observer->getBlock();
        $blockClass = get_class($block);

        if (!Mage::Helper('stripe')->getActive()) { return; }
        if ($blockClass != $targetBlock) { return; }
        if (!in_array('adminhtml_sales_order_create_index', $block->getLayout()->getUpdate()->getHandles())) { return; }

        $transport = $observer->getTransport();
        $html = $transport->getHtml();
        $extra = $block->getLayout()
            ->createBlock('adminhtml/template', 'stripe')
            ->setTemplate('stripe/javascript.phtml')
            ->toHtml();
        $transport->setHtml($html . $extra);
    }

}
