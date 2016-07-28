<?php

$installer = $this;
$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('sales/order')}
  ADD COLUMN `body_measurement` mediumtext default '';
");

$installer->run("

ALTER TABLE {$this->getTable('sales/quote')}
  ADD COLUMN `body_measurement` mediumtext default '';
");

$installer->endSetup();