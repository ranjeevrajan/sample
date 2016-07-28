<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('customer_arrtibute_metadata')}
    ADD COLUMN `shape_type_1` VARCHAR(255) NOT NULL default '' AFTER `image`,
    ADD COLUMN `shape_type_2` VARCHAR(255) NOT NULL default '' AFTER `shape_type_1`,
    ADD COLUMN `shape_type_3` VARCHAR(255) NOT NULL default '' AFTER `shape_type_2`;
");

$installer->endSetup();