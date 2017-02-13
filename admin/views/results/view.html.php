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
 * GenCellPharma View
 *
 * @since  0.0.1
 */
class GenCellPharmaViewResults extends JViewLegacy {
	/**
	 * Display the Users view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null) {
		$this->items = $this->get('Items');
		$this->files = $this->get('FileListToLoad');
		$this->pagination = $this->get('Pagination');
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
		JToolBarHelper::title(JText::_('COM_GENCELL_MANAGER_RESULTS'));
		JToolBarHelper::publishList('results.loadFiles');
	}
}