<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
JFormHelper::loadFieldClass ( 'list' );
/**
 * Tipos de Documento para los formularios del componente
 *
 * @since 0.0.1
 */
class JFormFieldPosition extends JFormFieldList {
	/**
	 * The field type.
	 *
	 * @var string
	 */
	protected $type = 'Position';
	
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return array An array of JHtml options.
	 */
	protected function getOptions() {
		$db = JFactory::getDBO ();
		$query = $db->getQuery ( true );
		$query->select ( 'id,position' );
		$query->from ( '#__gencell_position' );
		$db->setQuery ( ( string ) $query );
		$messages = $db->loadObjectList ();
		$options = array ();
		if ($messages) {
			foreach ( $messages as $message ) {
				$options [] = JHtml::_ ( 'select.option', $message->id, $message->greeting );
			}
		}
		$options = array_merge ( parent::getOptions (), $options );
		return $options;
	}
}