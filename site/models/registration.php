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
class GenCellPharmaModelRegistration extends JModelForm {
	
	/**
	 * @var array Datos del formulario
	 */
	private $data;
	
	/**
	 * Method to get the registration form.
	 *
	 * The base form is loaded from XML and then an event is fired
	 * for users plugins to extend the form with extra fields.
	 *
	 * @param array $data
	 *        	An optional array of data for the form to interogate.
	 * @param boolean $loadData
	 *        	True if the form is to load its own data (default case), false if not.
	 *        	
	 * @return JForm A JForm object on success, false on failure
	 *        
	 * @since 1.6
	 */
	public function getForm($data = array(), $loadData = true) {
		$form = $this->loadForm ( 'com_gencellpharma.registration', 'registration', array (
				'control' => 'jform',
				'load_data' => $loadData 
		) );
		if (empty ( $form )) {
			return false;
		}
		if (JLanguageMultilang::isEnabled ()) {
			$form->setFieldAttribute ( 'language', 'type', 'frontend_language', 'params' );
		}
		return $form;
	}
	
	public function getData() {
		if ($this->data === null) {
			$this->data = new stdClass;
			$app = JFactory::getApplication();
			// Override the base user data with any data in the session.
			$temp = (array) $app->getUserState('com_gencellpharma.registration.data', array());
			$form = $this->getForm(array(), false);
			foreach ($temp as $k => $v) {
				// Only merge the field if it exists in the form.
				if ($form->getField($k) !== false) {
					$this->data->$k = $v;
				}
			}
		}
		return $this->data;
	}
	
	protected function getGencellUser($documento) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('user_id', 'documento', 'doc_type_id', 'direccion', 'telefono', 'nombre', 'user_type_id')));
		$query->from($db->quoteName('#__gencell_user'));
		$query->where($db->quoteName('documento') . ' = '. $db->quote($documento));
		$db->setQuery($query);
		$results = $db->loadObject();
		if (!$results) {
			return null;
		}
		return $results;
	}
	
	public function register($temp) {
		$user = JFactory::getUser();
		$data = (array) $this->getData();
		foreach ($temp as $k => $v) {
			$data[$k] = $v;
		}
		$data['user_id'] = $user->id;
		$data['nombre'] = JFactory::getUser()->name;
		$data['user_type_id'] = 1;//Paciente
		$db = JFactory::getDbo();
		$usr = $this->getGencellUser($data['documento']);
		if ($usr == null) {
			$obj = json_decode(json_encode($data), false);
			$result = $db->insertObject('#__gencell_user', $obj);
		} else if ($usr->user_id < 0) {
			$data['nombre'] = $usr->nombre;
			$obj = json_decode(json_encode($data), false);
			$result = $db->updateObject('#__gencell_user', $obj, 'documento');
		} else {
			throw new Exception('Numero de documento ya registrado.');
		}
		if (!$result) {
			$this->setError($db->getErrorMsg());
			return false;
		}
		return true;
	}
}