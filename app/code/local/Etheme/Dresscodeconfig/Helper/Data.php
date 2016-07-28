<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Dresscodeconfig_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function compare_date($date_from, $date_to)
	{
		$output='';
        $cur_date = new Zend_Date();
		if (($date_to && strtotime($cur_date->__toString()) > $date_to) || ($date_from && strtotime($cur_date->__toString()) < $date_from) || (!$date_to && !$date_from)) return false; else return true;
	}



    public function outputProductLabel(Mage_Catalog_Model_Product $product)
	{
        $output = '';
		

        $product_sale_label=Mage::getStoreConfig("dresscodeconfig/dresscodeconfig_productlabels/product_sale_label");
        $product_new_label=Mage::getStoreConfig("dresscodeconfig/dresscodeconfig_productlabels/product_new_label");


		if($product_sale_label && $this->compare_date(strtotime($product->getData('special_from_date')), strtotime($product->getData('special_to_date'))))
            $output.= '<span class="product_sticker sticker_onsale_'.Mage::getStoreConfig('dresscodeconfig/dresscodeconfig_productlabels/product_sale_label_position').'"></span>';
        if($product_new_label && $this->compare_date(strtotime($product->getData('news_from_date')), strtotime($product->getData('news_to_date'))))
            $output.= '<span class="product_sticker sticker_new_'.Mage::getStoreConfig('dresscodeconfig/dresscodeconfig_productlabels/product_new_label_position').'"></span>';
		return $output;


	}

    public function briefText($text, $limit='55') {
        $str = strlen($text) > $limit ? substr(strip_tags($text), 0, $limit) . '&hellip;' : strip_tags($text);
        return $str;
    }


    function detectMobileDevice() {
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
        else if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            return true;
        }
        else if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
            return true;
        }
        else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'macintosh') > 0) {
            return false;
        }
        else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'linux') > 0) {
            return false;
        }
        else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
            return false;
        }
        else if (in_array($mobile_ua,$mobile_agents)) {
            return true;
        }
        else {
            return true;
        }
    }



}

