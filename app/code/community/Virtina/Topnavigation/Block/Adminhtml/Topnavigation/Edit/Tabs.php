<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Block_Adminhtml_Topnavigation_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('menu_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('topnavigation')->__('Menu Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('topnavigation')->__('Menu Information'),
          'title'     => Mage::helper('topnavigation')->__('Menu Information'),
          'content'   => $this->getLayout()->createBlock('topnavigation/adminhtml_topnavigation_edit_tab_form')->toHtml(),
      ));

      $this->addTab('content_section', array(
          'label'     => Mage::helper('topnavigation')->__('Content'),
          'title'     => Mage::helper('topnavigation')->__('Content'),
          'content'   => $this->getLayout()->createBlock('topnavigation/adminhtml_topnavigation_edit_tab_content')->toHtml(),
      ));   
      return parent::_beforeToHtml();
  }
}
