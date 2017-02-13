<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * User Table class
 *
 * @since 0.0.1
 */
class GencellTableUser extends JTable {
	
	/**
	 * Constructor
	 *
	 * @param
	 *        	JDatabaseDriver &$db A database connector object
	 */
	function __construct(&$db) {
		parent::__construct ( '#__gencell_user', 'user_id', $db );
	}
}