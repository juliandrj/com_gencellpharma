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
 * Users Controller
 *
 * @since  0.0.1
 */
class GenCellPharmaControllerResults extends JControllerAdmin {
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Results', $prefix = 'GenCellPharmaModel', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	public function loadFiles() {
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$app = JFactory::getApplication();
		$model = $this->getModel();
		$files = $model->getFileListToLoad();
		$hasError = false;
		if (!$files || empty($files)) {
			$app->enqueueMessage(JText::_('COM_GENCELL_EMPTY_FILE_LIST'), 'warning');
		} else {
			foreach ($files as $f) {
				try {
					$model->storeResult($f[0], $f[1]);
					$model->moveFile($f[1]);
				} catch (Exception $ex) {
					$app->enqueueMessage($ex->getMessage(), 'error');
					$hasError = true;
				}
			}
		}
		if (!$hasError) {
			$app->enqueueMessage(JText::_('COM_GENCELL_FILE_LIST_PROCESSED'), 'success');
		}
		$this->setRedirect(JRoute::_('index.php?option=com_gencellpharma&view=results', false));
		return true;
	}
}