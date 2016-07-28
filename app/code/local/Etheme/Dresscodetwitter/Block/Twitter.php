<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodetwitter_Block_Twitter extends Mage_Core_Block_Template
{

    function getTwitts()
    {
        $config_soc = Mage::getStoreConfig('dresscodeconfig/dresscodeconfig_socials');
        $login = $config_soc['twitter'];

        $ExternalLibPath=Mage::getModuleDir('', 'Etheme_Dresscodetwitter') . DS . 'lib' . DS .'twitter.class.php';
        require_once ($ExternalLibPath);


        $twitter = new Twitter('mHLVU8JL8MqOFAOiTf4kkw','iXCNt0bvXT6CJxmHOaEdnG3XBK8i0yQkxLQGrmz2GzM');
        $twitter->setOAuthToken('245875355-m6yVpzk90R6f0sKayGUFlP8Zlt81PTRMBDObtTeZ');
        $twitter->setOAuthTokenSecret('VjrBFJDspC3mOAq1KSqHWzwlLfwr9OUrPw8eNkoTpcs');
        $output = $twitter->statusesUserTimeline('','@'.$login);

        return $output;
    }


}
