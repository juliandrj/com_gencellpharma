<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
/**
 * Users View
 *
 * @since  0.0.1
 */
class GenCellPharmaViewUser extends JViewLegacy
{
	/**
	 * View form
	 *
	 * @var         form
	 */
	protected $form = null;
 
	/**
	 * Display the Users view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null) {
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		$this->addToolBar();
		parent::display($tpl);
	}
 
	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar() {
		$input = JFactory::getApplication()->input;
		$input->set('hidemainmenu', true);
		JToolBarHelper::title(JText::_('COM_GENCELL_USER_EDIT'), 'user');
		JToolBarHelper::save('user.save');
		JToolBarHelper::cancel('user.cancel','JTOOLBAR_CLOSE');
	}
}