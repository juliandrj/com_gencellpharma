<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
JLoader::register('GenCellPharmaController', JPATH_COMPONENT . '/controller.php');
/**
 * GenCell Component Controller
 *
 * @since 0.0.1
 */
class GenCellPharmaControllerRegistration extends GenCellPharmaController {

	public function register() {
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$user = JFactory::getUser();
		if ($user->guest) {
			return false;
		}
		$app = JFactory::getApplication();
		$model = $this->getModel('Registration', 'GenCellPharmaModel');
		$requestData = $this->input->post->get('jform', array(), 'array');
		$form = $model->getForm();
		if (!$form){
			JError::raiseError(500, $model->getError());
			return false;
		}
		$data = $model->validate($form, $requestData);
		if ($data === false) {
			// Get the validation messages.
			$errors = $model->getErrors();
			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
			// Save the data in the session.
			$app->setUserState('com_gencellpharma.registration.data', $requestData);
			// Redirect back to the registration screen.
			$this->setRedirect(JRoute::_('index.php?option=com_gencellpharma?view=registration', false));
			return false;
		}
		// Attempt to save the data.
		$return = $model->register($data);
		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_gencellpharma.registration.data', $data);
			// Redirect back to the edit screen.
			$this->setMessage($model->getError(), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_gencellpharma', false));
			return false;
		}
		// Flush the data from the session.
		$app->setUserState('com_gencellpharma.registration.data', null);
		$this->setMessage(JText::_('COM_GENCELLPHAR_REGISTRATION_SAVE_SUCCESS'));
		$this->setRedirect(JRoute::_('index.php?option=com_gencellpharma', false));
		return true;
	}
	
}