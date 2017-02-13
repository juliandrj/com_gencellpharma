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
 * GenCellPharma Model
 *
 * @since 0.0.1
 */
class GenCellPharmaModelGenCellPharma extends JModelItem {
	
	/**
	 * 
	 * @return array
	 */
	public function getGencellUser() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('user_id', 'documento', 'doc_type_id', 'direccion', 'telefono', 'nombre', 'user_type_id')));
		$query->from($db->quoteName('#__gencell_user'));
		$query->where($db->quoteName('user_id') . ' = '. JFactory::getUser()->id);
		$db->setQuery($query);
		$results = $db->loadObject();
		if (!$results) {
			return null;
		}
		return $results;
	}
	
	public function getGencellEnterprise() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('e.id', 'e.nombre', 'e.nit', 'p.position')));
		$query->from($db->quoteName('#__gencell_enterprise', 'e'));
		$query->join('inner', $db->quoteName('#__gencell_employee', 't') . 'on ' . $db->quoteName('e.id') . '=' . $db->quoteName('t.enterprise_id'));
		$query->join('inner', $db->quoteName('#__gencell_position', 'p') . 'on ' . $db->quoteName('p.id') . '=' . $db->quoteName('t.position_id'));
		$query->where($db->quoteName('t.user_id') . ' = ' . JFactory::getUser()->id);
		$db->setQuery($query);
		$results = $db->loadObject();
		if (!$results) {
			return null;
		}
		return $results;
	}
	
	public function getClientList($enterpriseId) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('u.user_id', 'u.documento', 'u.doc_type_id', 'u.direccion', 'u.telefono', 'u.nombre', 'u.user_type_id')));
		$query->from($db->quoteName('#__gencell_user', 'u'));
		$query->join('inner', $db->quoteName('#__gencell_result', 'r') . 'on ' . $db->quoteName('u.user_id') . '=' . $db->quoteName('r.user_id'));
		$query->where($db->quoteName('r.petitioner_id') . ' = ' . $enterpriseId);
		$query->order($db->quoteName('u.nombre'));
		$query->group($db->quoteName('u.user_id'));
		$db->setQuery($query);
		$results = $db->loadObjectList();
		if (!$results) {
			return null;
		}
		return $results;
	}
	
	public function getResultList($userId, $enterpriseId = null) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('r.id', 'r.user_id', 'r.upload_date', 'r.path')));
		$query->from($db->quoteName('#__gencell_result', 'r'));
		if ($enterpriseId == null) {
			$query->where($db->quoteName('r.user_id') . ' = ' . $userId);
		} else {
			$query->where(array($db->quoteName('r.user_id') . ' = ' . $userId . ' and ' . $db->quoteName('r.petitioner_id') . ' = ' . $enterpriseId));
		}
		$query->order($db->quoteName('r.upload_date') . ' desc');
		$db->setQuery($query);
		$results = $db->loadObjectList();
		if (!$results) {
			return null;
		}
		return $results;
	}
	
	public function getResultFile() {
		$jinput = JFactory::getApplication()->input;
		$token = $jinput->get('idr', 'abcde');
		$enc = new JSimpleCrypt(JFactory::getConfig()->get('secret'));
		//FIXME: hace falta hacer vencer el token
		$id = $enc->decrypt($token);
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('r.id', 'r.path')));
		$query->from($db->quoteName('#__gencell_result', 'r'));
		$query->where($db->quoteName('r.id') . ' = ' . $id);
		$db->setQuery($query);
		$result = $db->loadObject();
		if (!$result) {
			throw new Exception('No existe el elemento.');
		}
		return JPATH_ROOT . '/../gencellpharma_files/' . $result->path;
	}
	
	public function getJsonObject() {
		$jinput = JFactory::getApplication()->input;
		$opt = $jinput->get('opt', 'n/a');
		$ent = $this->getGencellEnterprise();
		$enc = new JSimpleCrypt(JFactory::getConfig()->get('secret'));
		$ret = null;
		switch ($opt) {
			case 'results':
				$ret = $this->getResultList(JFactory::getUser()->id);
				if (is_array($ret)) {
					foreach ($ret as $res) {
						$res->id = $enc->encrypt($res->id);
						$res->user_id = $enc->encrypt($res->user_id);
						$res->path = null;
					}
				}
				break;
			case 'client_list':
				if ($ent != null) {
					$ret = $this->getClientList($ent->id);
					if (is_array($ret)) {
						foreach ($ret as $usr) {
							$usr->user_id = $enc->encrypt($usr->user_id);
						}
					}
				} else {
					throw new Exception('Opción no valida: ' . $opt);
				}
				break;
			case 'client_results':
				if ($ent != null) {
					$ret = $this->getResultList($enc->decrypt($jinput->get('id', 'abcdef')), $ent->id);
					if (is_array($ret)) {
						foreach ($ret as $res) {
							$res->id = $enc->encrypt($res->id);
							$res->user_id = $enc->encrypt($res->user_id);
						}
					}
				} else {
					throw new Exception('Opción no valida: ' . $opt);
				}
				break;
			default:
				throw new Exception('Opción no valida: ' . $opt);
		}
		return $ret;
	}
	
}