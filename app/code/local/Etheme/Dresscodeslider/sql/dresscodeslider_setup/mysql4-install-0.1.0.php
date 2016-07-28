<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

$installer = $this;
$installer->startSetup();
$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('dresscodeslider')}`;
CREATE TABLE `{$this->getTable('dresscodeslider')}` (
  `slide_id` int(11) unsigned NOT NULL auto_increment,
  `image` varchar(255) NOT NULL default '',
  `image1` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `link_1` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `{$this->getTable('dresscodeslider')}` (`slide_id`, `image`, `image1`, `link`, `link_1`, `status`) VALUES (1, 'etheme/dresscode/dresscodeslider/slider_img1.jpg', 'etheme/dresscode/dresscodeslider/slider_img2.jpg', '#', '#', 1);
INSERT INTO `{$this->getTable('dresscodeslider')}` (`slide_id`, `image`, `image1`, `link`, `link_1`, `status`) VALUES (2, 'etheme/dresscode/dresscodeslider/slider_img3.jpg', 'etheme/dresscode/dresscodeslider/slider_img4.jpg', '#', '#', 1);
INSERT INTO `{$this->getTable('dresscodeslider')}` (`slide_id`, `image`, `image1`, `link`, `link_1`, `status`) VALUES (3, 'etheme/dresscode/dresscodeslider/slider_img5.jpg', 'etheme/dresscode/dresscodeslider/slider_img6.jpg', '#', '#', 1);



");

$installer->endSetup();

