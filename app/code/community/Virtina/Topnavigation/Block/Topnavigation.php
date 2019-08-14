<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Block_Topnavigation extends Mage_Page_Block_Html_Topmenu
{
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
    }
	/**
     * Get menu items
     *
     * @return array
     */    
	public function getMenuitem()
    {
        $activeMenuItems = Mage::getModel('topnavigation/topnavigation')
							->getCollection()
							->addFieldToFilter('status',1)
							->setOrder('sort_order','ASC'); //show only enabled
		return $activeMenuItems;
    }
}
