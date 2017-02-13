<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
/**
 * File manager helper.
 *
 * @since  1.6
 */
class FileManagerHelper {
	
	private function loadObjectsFromFileName($file) {
		$datos = split('[_]+', $file);
		if (empty($datos) || count($datos) < 4) {
			return null;
		}
		$user = new stdClass();
		$user->user_id = 0;
		$user->documento = $datos[0];
		$user->doc_type_id = 1;
		$user->direccion = 'n/r';
		$user->telefono = '0';
		$user->nombre = str_replace('.pdf', '', trim($datos[3]));
		$user->user_type_id = 1;
		$result = new stdClass();
		$result->user_id = 0;
		try {
			$result->upload_date = date_format(date_create_from_format('dmY', $datos[2]), 'Y-m-d');
		} catch (Exception $e) {
			$result->upload_date = '1900-01-01';
		}
		$result->path = 'load/' . $file;
		$result->petitioner_id = '' . $datos[1] == '00' ? null : $datos[1];
		return array($user, $result);
	}
	
	public function fileListToLoad () {
		$files = scandir(JPATH_ROOT . '/../gencellpharma_files/unload/');
		if (!$files) {
			return array();
		}
		$files = array_diff($files, array('.', '..'));
		$upload = array();
		foreach ($files as $f) {
			$up = $this->loadObjectsFromFileName($f);
			if ($up != null && !empty($up)) {
				array_push($upload, $this->loadObjectsFromFileName($f));
			}
		}
		return $upload;
	}
	
	 public function moveFile($result) {
	 	if (!rename(JPATH_ROOT . '/../gencellpharma_files/un' . $result->path, JPATH_ROOT . '/../gencellpharma_files/' . $result->path)) {
	 		throw new Exception('No se logró mover el archivo: ' . $result->path);
	 	}
	 }
}
