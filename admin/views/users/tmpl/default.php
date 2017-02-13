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
	<li role="presentation" class="active"><a href="#"><?php echo JText::_('COM_GENCELL_USERS');?></a></li>
	<li role="presentation"><a href="<?php echo JRoute::_('index.php?option=com_gencellpharma&view=results');?>"><?php echo JText::_('COM_GENCELL_RESULTS');?></a></li>
	<li role="presentation"><a href="<?php echo JRoute::_('index.php?option=com_gencellpharma&view=enterprises');?>"><?php echo JText::_('COM_GENCELL_ENTERPRISES');?></a></li>
</ul>
<form action="index.php?option=com_gencellpharma&view=users" method="post" id="adminForm" name="adminForm">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th><?php echo JHtml::_('grid.checkall'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_DOC'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_DOC_TYPE'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_ADDRESS'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_PHONE'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_NAME'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_USER_TYPE'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_EMAIL'); ?></th>
				<th><?php echo JText::_('COM_GENCELL_USERNAME'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : ?>
					<tr<?php if ($row->user_type_id != 1){?> class="warning"<?php } else if (!$row->username) {?> class="error"<?php }?>>
						<td><?php echo $this->pagination->getRowOffset($i); ?></td>
						<td><?php echo JHtml::_('grid.id', $i, $row->user_id); ?></td>
						<td><?php echo $row->documento; ?></td>
						<td><?php echo $row->doc_type; ?></td>
						<td><?php echo $row->direccion; ?></td>
						<td><?php echo $row->telefono; ?></td>
						<td><?php echo $row->nombre; ?></td>
						<td><?php echo $row->user_type; ?></td>
						<td><?php echo $row->email; ?></td>
						<td><?php echo $row->username; ?></td>
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
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
</form>