<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Block_Adminhtml_Topnavigation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {	
    $this->_controller = 'adminhtml_topnavigation';
    $this->_blockGroup = 'topnavigation';
    $this->_headerText = Mage::helper('topnavigation')->__('Menu Manager');
    $this->_addButtonLabel = Mage::helper('topnavigation')->__('Add Menu Item');
    parent::__construct();
  }
}
