<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
$controller = JControllerLegacy::getInstance('GenCellPharma');
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
$controller->redirect();