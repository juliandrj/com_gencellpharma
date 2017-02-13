<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * HTML View class for the GenCellPharma Component
 *
 * @since 0.0.1
 */
class GencellpharmaViewRegistration extends JViewLegacy {
	/**
	 * Display the GenCellPharma view
	 *
	 * @param string $tpl
	 *        	The name of the template file to parse; automatically searches through the template paths.
	 *        	
	 * @return void
	 */
	function display($tpl = null) {
		$this->user = JFactory::getUser();
		$this->form = $this->get('Form');
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JLog::add ( implode ( '<br />', $errors ), JLog::WARNING, 'jerror' );
			return false;
		}
		parent::display($tpl);
		return true;
	}
}