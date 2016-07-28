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
class TemplateTag_Stripe_Block_Payment extends Mage_Payment_Block_Form
{
    /**
     * Sets the default template to use for this block
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('stripe/payment.phtml');
    }

    /**
     * Generates and returns an array of expiry years with the given range parameter
     * eg array('2001' => '2001', '2002' => '2002', ...)
     *
     * @param bool $placeholder
     * @param int $range
     * @return array
     */
    public function getExpiryYears($placeholder = true, $range = 10)
    {
        $_result = array();

        if ($placeholder){ $_result[] = array('', $this->__('Years')); }

        $_year = Mage::getModel('core/date')->date('Y');

        foreach (range($_year, $_year + $range) as $_year) {
            $_result[] = array($_year, $_year);
        }

        return $_result;
    }

    /**
     * Generates and returns an array of expiry months with an optional placeholder
     * eg: array('01' => '01 - January', '02' => '02 - February, ...)
     *
     * @param bool $placeholder
     * @return array
     */
    public function getExpiryMonths($placeholder = true)
    {
        $_result = array();
        if ($placeholder) { $_result[] = array('', $this->__('Months')); }

        foreach (range(1, 12) as $value)
        {
            $_month = mktime(0, 0, 0, $value, 1);
            $_number = date('m', $_month);
            $_result[] = array($_number, $_number . ' - ' .date('F', $_month));
        }
        return $_result;
    }

    /**
     * Returns the named used for the credit card
     *
     * @return mixed string|null
     */
    public function getCcName()
    {
        return $this->getInfoData('cc_owner');
    }

    /***
     * Returns the last 4 credit card numbers presented with stars
     *
     * @return mixed string|null
     */
    public function getCcNumber()
    {
        if ($ccLast4 = $this->getInfoData('cc_last4')) {
            return sprintf('**** **** **** %s', $ccLast4);
        }
        return null;
    }

    /***
     * Returns a cvc placeholder if a credit card number was present
     *
     * @return mixed string|null
     */
    public function getCcCvc()
    {
        return $this->getCcNumber() ? '***' : null;
    }

    /**
     * Returns the expiry month of the credit card
     *
     * @return mixed string|null
     */
    public function getCcExpMonth()
    {
        return $this->getInfoData('cc_exp_month');
    }

    /**
     * Returns the expiry year of the credit card
     *
     * @return mixed string|null
     */
    public function getCcExpYear()
    {
        return $this->getInfoData('cc_exp_year');
    }
}
