<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->setCharset('utf-8');
$document->setMimeEncoding('application/json');
JResponse::setHeader('Content-Disposition','inline');
echo $this->obj == null ? '{"exception":"no-data-found"}' : json_encode($this->obj);
