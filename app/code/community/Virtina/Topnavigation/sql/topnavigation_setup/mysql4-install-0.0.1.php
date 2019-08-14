<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
$setup->addAttribute('catalog_category', 'icon_image', array(
	'group' => 'General Information',
	'input' => 'image',
	'type' => 'varchar',
	'label' => 'Icon Image',
	'backend' => 'catalog/category_attribute_backend_image',
	'visible' => 1,
	'required' => false,
	'user_defined' => 1,
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	)
);

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('topnavigation')};
CREATE TABLE {$this->getTable('topnavigation')} (
  `menu_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `link` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `sort_order` int(11) unsigned NOT NULL,
  `content_type` smallint(6) NOT NULL default '0',
  `product_box_title` varchar(255) NOT NULL default '',
  `column_count` int(11) unsigned NOT NULL,
  `product_ids` varchar(255) NOT NULL default '',
  `category_title` varchar(255) NOT NULL default '',
  `category_ids` varchar(255) NOT NULL default '',
  `description` text(255) NOT NULL default '',  
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
    
$installer->endSetup();
