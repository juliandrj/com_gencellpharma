<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted Access');
?>
<ul class="nav nav-tabs">
	<li role="presentation"><a href="<?php echo JRoute::_('index.php?option=com_gencellpharma&view=users');?>"><?php echo JText::_('COM_GENCELL_USERS');?></a></li>
	<li role="presentation" class="active"><a href="#"><?php echo JText::_('COM_GENCELL_RESULTS');?></a></li>
	<li role="presentation"><a href="<?php echo JRoute::_('index.php?option=com_gencellpharma&view=enterprises');?>"><?php echo JText::_('COM_GENCELL_ENTERPRISES');?></a></li>
</ul>
<form action="index.php?option=com_gencellpharma&view=results" method="post" id="adminForm" name="adminForm">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th colspan="6"><?php echo JText::_('COM_GENCELL_TO_UPLOAD_FILES'); ?></th>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th><?php echo JText::_('COM_GENCELL_DOC'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_NAME'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_DATE'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_PETITIONER'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_FILE_NAME'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($this->files)) : ?>
				<?php foreach ($this->files as $i => $row) : ?>
					<tr>
						<td><?php echo $i + 1; ?></td>
						<td><?php echo $row[0]->documento; ?></td>
						<td><?php echo $row[0]->nombre; ?></td>
						<td><?php echo $row[1]->upload_date; ?></td>
						<td><?php echo $row[1]->petitioner_id; ?></td>
						<td><?php echo 'un' . $row[1]->path; ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="6"><?php echo JText::_('COM_GENCELL_NONE_TO_UPLOAD'); ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<hr/>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th colspan="3"><?php echo JText::_('COM_GENCELL_RESULT_COUNT'); ?></th>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th><?php echo JText::_('COM_GENCELL_ENTERPRISE'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_RESULT_COUNT'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : ?>
					<tr>
						<td><?php echo $this->pagination->getRowOffset($i); ?></td>
						<td><?php echo $row->nombre; ?></td>
						<td><?php echo $row->resultados; ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="1"/>
	<?php echo JHtml::_('form.token'); ?>
</form>