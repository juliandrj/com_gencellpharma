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
$document->setMimeEncoding('application/pdf');
JResponse::setHeader('Content-Disposition','inline; filename=resultado.pdf');
JResponse::setHeader('Content-Transfer-Encoding','binary');
JResponse::setHeader('Content-Length',filesize($this->pdf));
JResponse::setHeader('Accept-Ranges','bytes');
@readfile($this->pdf);
