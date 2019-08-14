<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Block_Adminhtml_Topnavigation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	/**
     * Enabling wysiwyg editor 
     *
     * @return array
     */	
	protected function _prepareLayout() {
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
				$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
				$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		}
		parent::_prepareLayout();
	}
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'topnavigation';
        $this->_controller = 'adminhtml_topnavigation';
        
        $this->_updateButton('save', 'label', Mage::helper('topnavigation')->__('Save Menu'));
        $this->_updateButton('delete', 'label', Mage::helper('topnavigation')->__('Delete Menu'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('web_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'web_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'web_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('topnavigation_data') && Mage::registry('topnavigation_data')->getId() ) {
            return Mage::helper('topnavigation')->__("Edit Menu '%s'", $this->htmlEscape(Mage::registry('topnavigation_data')->getName()));
        } else {
            return Mage::helper('topnavigation')->__('Add Menu');
        }
    }
}
