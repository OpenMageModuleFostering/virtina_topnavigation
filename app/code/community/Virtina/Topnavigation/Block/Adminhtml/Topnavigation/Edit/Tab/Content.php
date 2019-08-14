<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Block_Adminhtml_Topnavigation_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form
{
	/**
     * Preparing form for Tab : Content 
     *
     * @return array
     */	
  
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')
		->getConfig(array( 
			'add_widgets' => true, 
			'add_variables' => true, 
			'add_images' => true,  
			'files_browser_window_url'=> $this->getBaseUrl().'admin/cms_wysiwyg_images/index/'
		));
		
        $fieldset = $form->addFieldset('productselector_form', array('legend'=>Mage::helper('topnavigation')->__('General')
		));

		$field = $fieldset->addField('content_type', 'select', array( 
			'label' => Mage::helper('topnavigation')->__('Main Content Type'), 
			'class' => 'required-entry', 
			'required' => true, 
			'name' => 'content_type', 
			'value' => '1', 
			'values' => array(
				'-1'=>'Please Select content type',
				'1' => 'Anchor Text',
				'2' => 'Product Listing', 
				'3' => 'Content',
				'4' => 'Category Listing'), 
			'tabindex' => 1 ,
			'onchange' => 'showHide(this.value)'
		));
		
		$field->setAfterElementHtml('<script> 
		function showHide(value) {    
			if (value == "2") {	
				$("product_chooser").show();
			} else {
				$("product_chooser").hide();
			}
		}
		function showGrid(){
			$("product_chooser").show();
		}
		$j(document).ready(function() {
			$j("#product_chooser").hide();
		});	
		</script>');
		
		$fieldset->addField('link', 'text', array(
			'label'     => Mage::helper('topnavigation')->__('URL'),
			'class'     => 'validate-identifier input-text required-entry',
			'name'      => 'link',
			'after_element_html' => '<small>Eg:home/</small>',
		));

		$fieldset->addField('product_box_title', 'text', array(
			'label'     => Mage::helper('topnavigation')->__('Products Box Title'),
			'name'      => 'product_box_title',
		));
		
		$fieldset->addField('column_count', 'select', array( 
			'label'		=> Mage::helper('topnavigation')->__('The number of Products in a row'), 
			'class' 	=> 'required-entry', 
			'required' 	=> true, 
			'name' 		=> 'column_count', 
			'value' 	=> '1', 
			'values' 	=> array(
				'4' => '4', 
				'5' => '5', 
				'6' => '6'), 
			'tabindex'	=> 1 
		));		
			
		$url =  Mage::getUrl('adminhtml/topnavigation/chooser/attribute/entityid/form/rule_conditions_fieldset', array('_secure' => Mage::app()->getStore()->isAdminUrlSecure())) .'?isAjax=true\'';
        $fieldset->addField('product_ids', 'text', array(
            'label'    => Mage::helper('topnavigation')->__('Product(s)'),
            'name'     => 'product_ids',
            'required' => true, 
            'class'    => 'rule_conditions_fieldset',
            'readonly' => false, 
            'after_element_html' => '<br/><br/><button type="button" class="rule-chooser-trigger" onclick="showGrid(); getProductChooser(\'' .$url. ',document.getElementById(\'product_ids\').value); return false;">Select Product(s)</button>'              
        ));

		$fieldset->addField('category_title', 'text', array(
			'label'    => Mage::helper('topnavigation')->__('Category Box Title'),
			'name'     => 'category_title',
		));

		$url =  $this->getLayout()->createBlock('topnavigation/adminhtml_topnavigation_chooser_categories')->toHtml();
        $fieldset->addField('category_ids', 'text', array(
            'label'    => Mage::helper('topnavigation')->__('Category'),
            'name'     => 'category_ids',
            'required' => true, 	
            'after_element_html' => '<br/><br/>'.$url,            
        ));
                               
		$fieldset->addField('description', 'editor', array(
			'name'      => 'description',
			'label'     => Mage::helper('topnavigation')->__('Content'),
			'title'     => Mage::helper('topnavigation')->__('Content'),
			'style'     => 'height:35em;width:45em;',
			'config'    => $wysiwygConfig,
			'wysiwyg'   => true,
			'required'  => false,
		));	
		        
		$fieldset->addFieldset('product_chooser', array('legend' => (''))); 
      
		$this->setChild('form_after', $this->getLayout()
		   ->createBlock('adminhtml/widget_form_element_dependence')
           ->addFieldMap('content_type', 'content_type')
           ->addFieldMap('link', 'link')
           ->addFieldMap('product_box_title', 'product_box_title')
           ->addFieldMap('column_count', 'column_count')
           ->addFieldMap('product_ids', 'product_ids')
           ->addFieldMap('category_ids', 'category_ids')
           ->addFieldMap('category_title', 'category_title')
           ->addFieldMap('description', 'description')
           ->addFieldDependence('link', 'content_type', 1) 
           ->addFieldDependence('product_box_title', 'content_type', 2)
           ->addFieldDependence('column_count', 'content_type', 2) 
           ->addFieldDependence('product_ids', 'content_type', 2) 
           ->addFieldDependence('category_ids', 'content_type', 4) 
           ->addFieldDependence('category_title', 'content_type', 4) 
           ->addFieldDependence('description', 'content_type', 3) 
	    );		  		
          
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
