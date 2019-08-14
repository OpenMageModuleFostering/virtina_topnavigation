<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Block_Adminhtml_Topnavigation_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('menu_form', array('legend'=>Mage::helper('topnavigation')->__('Menu information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('topnavigation')->__('Front-end label'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));

      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('topnavigation')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('topnavigation')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('topnavigation')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('sort_order', 'text', array(
          'label'     => Mage::helper('topnavigation')->__('Sort Order'),
          'required'  => false,
          'name'      => 'sort_order',
	  ));
	  
     
      if ( Mage::getSingleton('adminhtml/session')->getMenuData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMenuData());
          Mage::getSingleton('adminhtml/session')->getMenuData(null);
      } elseif ( Mage::registry('topnavigation_data') ) {
          $form->setValues(Mage::registry('topnavigation_data')->getData());
      }
      return parent::_prepareForm();
  }
}
