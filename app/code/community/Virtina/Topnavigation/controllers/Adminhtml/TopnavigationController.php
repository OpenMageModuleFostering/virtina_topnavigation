<?php
/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Topnavigation_Adminhtml_TopnavigationController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('topmenu/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('topnavigation/topnavigation')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('topnavigation_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('topmenu/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('topnavigation/adminhtml_topnavigation_edit'))
				 ->_addLeft($this->getLayout()->createBlock('topnavigation/adminhtml_topnavigation_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('topnavigation')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {	
			$contentType = $data['content_type'];
			if ($contentType == 1) { $data['product_box_title'] = '';$data['column_count'] = '';$data['product_ids'] = '';$data['category_title'] = '';$data['category_ids'] = '';$data['description'] = '';}
			elseif($contentType == 2){ $data['link'] = '';$data['category_title'] = '';$data['category_ids'] = '';$data['description'] = '';}
			elseif($contentType == 3){ $data['link'] = '';$data['category_title'] = '';$data['category_ids'] = '';$data['product_box_title'] = '';$data['column_count'] = '';$data['product_ids'] = '';}
			else { $data['product_box_title'] = '';$data['column_count'] = '';$data['product_ids'] = '';$data['link'] = '';$data['description'] = '';}	
			$categoryIds = explode(',', $data['category_ids']);
			$parentids = $categoryIds;
			
			foreach ($categoryIds as $categoryId):
				$_category = Mage::getModel('catalog/category')->load($categoryId);
				$ids = explode('/', $_category->getPath());
				$last = array_pop($ids);
				unset($ids[0], $ids[1], $last);
				$parentids = array_merge($parentids,$ids);
			endforeach;	
			
			$array = array_unique($parentids);
			$data['category_ids']= implode(',',$array);
			$model = Mage::getModel('topnavigation/topnavigation');		
			$model->setData($data)
				  ->setId($this->getRequest()->getParam('id'));
			
			try {				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('topnavigation')->__('Menu was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('topnavigation')->__('Unable to find menu to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('topnavigation/topnavigation');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Menu was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
    public function massDeleteAction() {
        $menuIds = $this->getRequest()->getParam('menuitem_id');
        if(!is_array($menuIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select menu item(s)'));
        } else {
            try {
                foreach ($menuIds as $menuId) {
                    $menu = Mage::getModel('topnavigation/topnavigation')->load($menuId);
                    $menu->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($menuIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $menuIds = $this->getRequest()->getParam('menuitem_id');
        if(!is_array($menuIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select menu item(s)'));
        } else {
            try {
                foreach ($menuIds as $menuId) {
                    $menu = Mage::getSingleton('topnavigation/topnavigation')
                        ->load($menuId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($menuIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    /**
     * Prepare block for chooser
     *
     * @return void
     */
    public function chooserAction()
    {	
        $request = $this->getRequest();
        switch ($request->getParam('attribute')) {
            case 'entityid':
                $block = $this->getLayout()->createBlock(
                    'topnavigation/adminhtml_topnavigation_chooser_entityid', 'adminhtml_topnavigation_chooser_entityid',
                    array('js_form_object' => $request->getParam('form'),
                ));                                 

                break;
            default:
                $block = false;
                break;
        }

        if ($block) {
            $this->getResponse()->setBody($block->toHtml());
        }
    }

    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('topnavigation/adminhtml_topnavigation_chooser_categories')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }
    
    protected function _isAllowed()
    {
        return true;
    }

}
