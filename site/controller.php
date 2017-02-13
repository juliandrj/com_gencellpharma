<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * GenCell Component Controller
 *
 * @since 0.0.1
 */
class GenCellPharmaController extends JControllerLegacy {
	
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController  This object to support chaining.
	 *
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false) {
		$user = JFactory::getUser();
		if ($user->guest) {
			$this->setMessage(JText::_('COM_GENCELLPHAR_LOGIN_FIRST'), 'warning');
			$redirectUrl = urlencode(base64_encode('index.php?option=com_gencellpharma'));
			$this->setRedirect('index.php?option=com_users&view=login&return=' . $redirectUrl);
			return;
		}
		$document = JFactory::getDocument();
		$model = $this->getModel('GenCellPharma');
		$vName = $this->input->getCmd('view', 'gencellpharma');
		if (!$model->getGencellUser()) {
			$vName = 'registration';
		} else if ($vName == 'registration') {
			$vName = 'gencellpharma';
		}
		$vFormat = $document->getType();
		$lName = $this->input->getCmd('layout', 'default');
		if ($view = $this->getView($vName, $vFormat)) {
			switch ($vName) {
				case 'registration':
					$model = $this->getModel('Registration');
					break;
			}
		}
		$view->setModel($model, true);
		$view->setLayout($lName);
		$view->document = $document;
		$view->display();
	}
}