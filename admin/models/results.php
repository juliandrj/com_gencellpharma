<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
JLoader::register('FileManagerHelper', JPATH_ADMINISTRATOR . '/components/com_gencellpharma/helpers/filemanager.php');
/**
 * UsersList Model
 *
 * @since  0.0.1
 */
class GenCellPharmaModelResults extends JModelList {
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery() {
		$db = JFactory::getDbo();
		$q1 = $db->getQuery(true);
		$q1->select(array($db->quoteName('e.id'), $db->quoteName('e.nombre'), 'count(r.id) as resultados'));
		$q1->from($db->quoteName('#__gencell_enterprise', 'e'));
		$q1->join('inner', $db->quoteName('#__gencell_result', 'r') . ' on ' . $db->quoteName('e.id') . '=' . $db->quoteName('r.petitioner_id'));
		$q1->group($db->quoteName('e.id'));
		$q2 = $db->getQuery(true);
		$q2->select(array('0 as id', '\'Individual\' as nombre', 'count(r.id) as resultados'));
		$q2->from($db->quoteName('#__gencell_result', 'r'));
		$q2->where($db->quoteName('r.petitioner_id') . ' is null');
		$q2->union($q1);
		return $q2;
	}
	
	public function getFileListToLoad() {
		$fm = new FileManagerHelper();
		return $fm->fileListToLoad();
	}
	
	public function getFakeUserId() {
		$db = JFactory::getDbo();
		$usrseq = new stdClass();
		$usrseq->id = null;
		$db->insertObject('#__gencell_usrseq', $usrseq);
		$q1 = $db->getQuery(true);
		$q1->select(array('max(s.id) as id'));
		$q1->from($db->quoteName('#__gencell_usrseq', 's'));
		$db->setQuery($q1);
		$seq = $db->loadObject();
		if ($seq) {
			return -1 * $seq->id;
		}
		throw new Exception('No se logró generar id.');
	}
	
	public function moveFile($result) {
		$fm = new FileManagerHelper();
		$fm->moveFile($result);
	}
	
	public function storeResult($user, $result) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('user_id')));
		$query->from($db->quoteName('#__gencell_user'));
		$query->where($db->quoteName('documento') . ' = '. $user->documento);
		$db->setQuery($query);
		$results = $db->loadObject();
		$id = !$results ? $this->getFakeUserId() : $results->user_id;
		if ($id < 0 && !$results) {
			$user->user_id = $id;
			if (!$db->insertObject('#__gencell_user', $user)) {
				throw new Exception('No se logro crear el usuario temporal: ' . $db->getError());
			}
		}
		$result->user_id = $id;
		if (!$db->insertObject('#__gencell_result', $result)) {
			throw new Exception('No se logro crear el resultado: ' . $db->getError());
		}
	}
}