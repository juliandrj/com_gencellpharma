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
 * UsersList Model
 *
 * @since  0.0.1
 */
class GenCellPharmaModelUsers extends JModelList {
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery() {
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('u.user_id', 'u.documento', 'u.doc_type_id', 'dt.doc_type', 'u.direccion', 'u.telefono', 'u.nombre', 'u.user_type_id', 'ut.user_type', 'uu.email', 'uu.username')));
		$query->from($db->quoteName('#__gencell_user', 'u'));
		$query->join('inner', $db->quoteName('#__gencell_doc_type', 'dt') . 'on ' . $db->quoteName('u.doc_type_id') . '=' . $db->quoteName('dt.id'));
		$query->join('inner', $db->quoteName('#__gencell_user_type', 'ut') . 'on ' . $db->quoteName('u.user_type_id') . '=' . $db->quoteName('ut.id'));
		$query->join('left', $db->quoteName('#__users', 'uu') . 'on ' . $db->quoteName('u.user_id') . '=' . $db->quoteName('uu.id'));
		return $query;
	}
}