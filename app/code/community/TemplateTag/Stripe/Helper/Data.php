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
class TemplateTag_Stripe_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * The unique code for our payment method
     *
     * @var string
     */
    protected $_code = 'stripe';

    /**
     * Returns the prefix used in the store config
     *
     * @return string
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Gets a field value from the store config
     *
     * @param string $field
     * @param mixed int|null $storeId
     * @return string
     */
    public function getConfigData($field, $storeId = null)
    {
        if (null === $storeId) {
            $storeId = Mage::app()->getStore();
        }
        $path = 'payment/'.$this->getCode().'/'.$field;
        return Mage::getStoreConfig($path, $storeId);
    }

    /**
     * Checks if the current payment method is enabled
     *
     * @param mixed int|null $storeId
     * @return bool
     */
    public function getActive($storeId = null)
    {
        return $this->getconfigData('active', $storeId);
    }

    /**
     * Checks if stripe is currently running in test mode
     *
     * @param mixed int|null $storeId
     * @return string
     */
    public function getTest($storeId = null)
    {
        return $this->getConfigData('test', $storeId);
    }

    /**
     * Gets the current stripe publishable key
     * You can force getting the live of dev key by passing the $test parameter
     * else it will default to the current store config
     *
     * @param bool $test
     * @param mixed int|null $storeId
     * @return string
     */
    public function getPublishableKey($test = null, $storeId = null)
    {
        $key = ($test || $this->getTest($storeId)) ? 'test_publishable_key' : 'publishable_key';
        return $this->getConfigData($key, $storeId);
    }

    /**
     * Gets the current stripe api key
     * You can force getting the live of dev key by passing the $test parameter
     * else it will default to the current store config
     *
     * @param bool $test
     * @param mixed int|null $storeId
     * @return string
     */
    public function getApiKey($test = null, $storeId = null)
    {
        $key = ($test || $this->getTest($storeId)) ? 'test_api_key' : 'api_key';
        $data = $this->getConfigData($key, $storeId);
        return Mage::helper('core')->decrypt($data);
    }

    /**
     * Used to pass variables to our namespaced javascript object
     *
     * @return string
     */
    public function getStripeJson()
    {
        return Mage::helper('core')->jsonEncode(array(
            'PublishableKey' => $this->getPublishableKey(),
            'MethodCode' => $this->getCode(),
            'Card' => new stdClass,
        ));
    }
}
