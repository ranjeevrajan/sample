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
class TemplateTag_Stripe_Block_Info extends Mage_Payment_Block_Info
{
    /**
     * Gets the name of the issuing credit card that was used
     *
     * @return mixed string|null
     */
    public function getCcTypeName()
    {
        return $this->getInfo()->getCcType();
    }

    /**
     * Gets the last 4 digits of the credit card that was used
     *
     * @return mixed string|null
     */
    public function getCcLast4()
    {
        return $this->getInfo()->getCcLast4();
    }

    /**
     * Gets the expiry month of the credit card that was used
     *
     * @return mixed string|null
     */
    public function getCcExpMonth()
    {
        return $this->getInfo()->getCcExpMonth();
    }

    /**
     * Gets the expiry year of the credit card that was used
     *
     * @return mixed string|null
     */
    public function getCcExpYear()
    {
        return $this->getInfo()->getCcExpYear();
    }

    /**
     * Gets the expiry date as a Zend_Date instance of the credit card that was used
     *
     * @return Zend_Date
     */
    public function getCcExpDate()
    {
        $date = Mage::app()->getLocale()->date(0);
        $date->setYear($this->getCcExpMonth());
        $date->setMonth($this->getCcExpYear());
        return $date;
    }

    /**
     * Prepares the data to be displayed within this form block and within both
     * email confirmation and pdf downloads
     *
     * @param null $transport
     * @return mixed
     */
    protected function _prepareSpecificInformation($transport = null)
    {

        if (null !== $this->_paymentSpecificInformation) {
            return $this->_paymentSpecificInformation;
        }

        $transport = parent::_prepareSpecificInformation($transport);
        $data = array();

        if ($ccType = $this->getCcTypeName()) {
            $data[Mage::helper('stripe')->__('Credit Card Type')] = $ccType;
        }
        if ($ccLast4 = $this->getInfo()->getCcLast4()) {
            $data[Mage::helper('stripe')->__('Credit Card Number')] = sprintf('**** **** **** %s', $ccLast4);
        }
        if (!$this->getIsSecureMode()) {
            $year = $this->getCcExpYear();
            $month = $this->getCcExpMonth();
            if ($year && $month) {
                $data[Mage::helper('stripe')->__('Expiry Date')] =  $this->_formatCardDate($year, $month);
            }
        }

        return $transport->setData(array_merge($data, $transport->getData()));
    }

    /**
     * Format year/month on the credit card
     *
     * @param string $year
     * @param string $month
     * @return string
     */
    protected function _formatCardDate($year, $month)
    {
        return sprintf('%s/%s', sprintf('%02d', $month), $year);
    }
}
