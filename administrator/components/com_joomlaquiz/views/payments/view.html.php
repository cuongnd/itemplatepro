<?php
/**
* Joomlaquiz Deluxe Component for Joomla 3
* @package Joomlaquiz Deluxe
* @author JoomPlace Team
* @copyright Copyright (C) JoomPlace, www.joomplace.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');

/**
 * Payments HTML View class for the Joomlaquiz Deluxe Component
 */
 
class JoomlaquizViewPayments extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
    public $messageTrigger = false;
    function display($tpl = null) 
	{
        $document = JFactory::getDocument();
        $document->addScript('components/com_joomlaquiz/assets/js/js.js');

		$app = JFactory::getApplication();
        $submenu = 'payments';
		JoomlaquizHelper::showTitle($submenu);
		$this->addTemplatePath(JPATH_BASE.'/components/com_joomlaquiz/helpers/html');
        $this->messageTrigger = $this->get('CurrDate');
		JoomlaquizHelper::addPaymentsSubmenu('payments');
		
        $this->addToolBar();
        	        	 
        $items 		= $this->get('Items');
        $pagination = $this->get('Pagination');
        $state		= $this->get('State');
        
		$usersFields = JHTML::_('select.options', $this->get('Users'), 'value', 'text', $app->getUserStateFromRequest('payments.filter.user_id', 'filter_user_id') );
		
		JHtmlSidebar::addFilter(
			JText::_('COM_JOOMLAQUIZ_SELECT_USER'),
			'filter_user_id',
			$usersFields
		);
		
        if (count($errors = $this->get('Errors'))) 
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
              
        $this->items = $items;
        $this->pagination = $pagination;
		$this->state = $state;
 		
		$this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }
 
    /**
    * Setting the toolbar
    */
	protected function addToolBar() 
    {
        JToolBarHelper::addNew('payment.add');
		JToolBarHelper::editList('payment.edit');
		JToolBarHelper::deleteList('', 'payments.delete');
        	
		JToolBarHelper::divider();    
    }
	
	protected function getSortFields()
	{
		return array(
			'id' => JText::_('COM_JOOMLAQUIZ_ID'),
			'product_name' => JText::_('COM_JOOMLAQUIZ_PRODUCT'),
			'amount' => JText::_('COM_JOOMLAQUIZ_AMOUNT'),
			'status' => JText::_('COM_JOOMLAQUIZ_STATUS'),
			'name' => JText::_('COM_JOOMLAQUIZ_USERNAME2')
		);
	}
}
