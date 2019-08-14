<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Model_Mysql4_Topnavigation extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the menu_id refers to the key field in your database table.
        $this->_init('topnavigation/topnavigation', 'menu_id');
    }
}
