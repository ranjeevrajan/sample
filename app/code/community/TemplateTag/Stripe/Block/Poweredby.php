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
class TemplateTag_Stripe_Block_Poweredby extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    /**
     * Preparing global layout
     *
     * Add stripe powered by css to any place this widget is shown
     *
     * @return TemplateTag_Stripe_Block_Poweredby
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->addCss('css/stripe/powerdby.css');
        return parent::_prepareLayout();
    }

    /**
     * Sets the block template to the powered by widget if not already defined/overridden
     *
     * @return string
     */
    public function getTemplate()
    {
        $template = parent::getTemplate();
        return $template ? $template : 'stripe/poweredby.phtml';
    }

    /**
     * Generates the image url for the configured widget
     *
     * @return string
     */
    public function getImageSrc()
    {
        return $this->getSkinUrl('images/stripe/' . $this->getStyle() . '.png');
    }
}
