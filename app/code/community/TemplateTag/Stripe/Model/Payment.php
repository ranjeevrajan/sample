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
class TemplateTag_Stripe_Model_Payment extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'stripe';

    protected $_isGateway                   = true;
    protected $_canAuthorize                = true;
    protected $_canCapture                  = true;
    protected $_canCapturePartial           = true;
    protected $_canRefund                   = true;
    protected $_canRefundInvoicePartial     = true;
    protected $_canVoid                     = true;
    protected $_canUseInternal              = true;
    protected $_canUseCheckout              = true;
    protected $_canUseForMultishipping      = true;
    protected $_canSaveCc                   = false;

    protected $_formBlockType = 'stripe/payment';
    protected $_infoBlockType = 'stripe/info';

    protected $_acceptedCurrencies = array('USD', 'CAD', 'GBP', 'EUR');

    /**
     * Retrieve model helper
     *
     * @return TemplateTag_Stripe_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('stripe');
    }

    /**
     * Sets the test or live key for the stripe library
     *
     * @return TemplateTag_Stripe_Model_Payment
     */
    protected  function _setApiKey()
    {
        $key = $this->_getHelper()->getApiKey($this->getTest());
        Stripe::setApiKey($key);
        return $this;
    }

    /**
     * Checks if stripe is currently running test mode, if an InfoInstance is
     * set then it will use the value for when the order was placed so that
     * order always stay in the state they where created in
     *
     * @return boolean
     */
    public function getTest()
    {
        try {
            $test = $this->getInfoInstance()->getStripeTest();
        } catch (Mage_Core_Exception $e) {
            $test = null;
        }
        return $test ? $test : $this->_getHelper()->getTest();
    }

    /**
     * Gets the current payment methods title, appends 'Test Mode' if the order
     * was placed when test mode was enabled
     *
     * @return stripe
     */
    public function getTitle()
    {
        $title = parent::getTitle();
        return $this->getTest() ? $this->_getHelper()->__('%s - Test Mode', $title) : $title;
    }

    /**
     * Assign data to info model instance
     *
     * @param Varien_Object|Array $data
     * @return TemplateTag_Stripe_Model_Payment
     */
    public function assignData($data)
    {
        if (is_array($data)) {
            $data = new Varien_Object($data);
        }

        try {
            $token = $this->getToken($data->getStripeToken());
            $data->addData(array(
                'cc_last4' => $token->card->last4,
                'cc_exp_year' => $token->card->exp_year,
                'cc_exp_month' => $token->card->exp_month,
                'cc_type' => $token->card->type,
                'cc_owner' => $token->card->name,
            ));
        } catch (Exception $e) {}


        $data->setData('stripe_test', $this->_getHelper()->getTest());

        return parent::assignData($data);
    }

    /**
     * Validate payment method information object
     *
     * @return TemplateTag_Stripe_Model_Payment
     */
    public function validate()
    {
        parent::validate();

        try {
            $this->getToken();
        } catch (Stripe_Error $e) {
            Mage::logException($e);
            Mage::throwException($this->_getHelper()->__('Invalid Stripe Token'));
        }

        return $this;
    }

    /**
     * Tries to fetch the current associated stripe token
     *
     * @param mixed null|string $token
     * @return Stripe_Token
     */
    public function getToken($token = null)
    {
        $this->_setApiKey();
        $token = $token ? $token : $this->getInfoInstance()->getStripeToken();
        return Stripe_Token::retrieve($token);
    }

    /**
     * Capture payment
     *
     * @param Varien_Object $payment
     * @param float $amount
     * @return TemplateTag_Stripe_Model_Payment
     */
    public function capture(Varien_Object $payment, $amount)
    {
        if ($amount <= 0.50) {
            Mage::throwException($this->_getHelper()->__('Invalid amount for capture.'));
        }

        /** @var $order Mage_Sales_Model_Order */
        $order = $payment->getOrder();

        $this->_setApiKey();

        try {
            $charge = Stripe_Charge::create(array(
                "amount" => $amount * 100,
                "currency" => $order->getBaseCurrency()->getCode(),
                "card" => $payment->getStripeToken(),
                "description" => $this->_getHelper()->__('Order # %s', $order->getIncrementId())
            ));
        } catch (Stripe_Error $e) {
            throw new Mage_Payment_Model_Info_Exception($this->_getHelper()->__('Payment Failed: %s', $e->getMessage()));
        }

        $payment->setTransactionId($charge->id);

        return $this;
    }

    /**
     * Refund specified amount for payment
     *
     * @param Varien_Object $payment
     * @param float $amount
     *
     * @return TemplateTag_Stripe_Model_Payment
     */
    public function refund(Varien_Object $payment, $amount)
    {
        $this->_setApiKey();
        $charge = Stripe_Charge::retrieve($payment->getCreditmemo()->getInvoice()->getTransactionId());
        $charge->refund(array(
            'amount' => $amount * 100
        ));
        return $this;
    }

    /**
     * Retrieve information from payment configuration
     *
     * @param string $field
     * @param int|string|null|Mage_Core_Model_Store $storeId
     * @return mixed
     */
    public function getConfigData($field, $storeId = null)
    {
        return $this->_getHelper()->getConfigData($field, $storeId);
    }

    /**
     * Check method is available for processing with base currency
     *
     * @param string $currencyCode
     * @return boolean
     */
    public function canUseForCurrency($currencyCode)
    {
        return in_array(strtolower($currencyCode), $this->getAcceptedCurrencyCodes());
    }
    /**
     * Fetches the supported currencies form the configured stripe account
     *
     * @return array
     */
    public function getAcceptedCurrencyCodes()
    {
        if (!$this->hasData('_accepted_currency')) {
            try {
                $this->_setApiKey();
                $currencies = Stripe_Account::retrieve()->currencies_supported;
            } catch (Stripe_Error $e) {
                Mage::log("Couldn't fetch the supported currencies for your stripe account");
                $currencies = $this->_acceptedCurrencies;
            }
            $this->setData('_accepted_currency', $currencies);
        }
        return $this->_getData('_accepted_currency');
    }

}
