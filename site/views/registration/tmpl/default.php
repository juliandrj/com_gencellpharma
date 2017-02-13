<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
?>
<h1><?php echo JText::_('COM_GENCELLPHAR_REGISTER_FORM_TITLE');?></h1>
<p><?php echo JText::_('COM_GENCELLPHAR_REGISTER_INTRO_TEXT');?></p>
<p><?php echo JText::_('COM_GENCELLPHAR_REGISTER_EMAIL_LABEL');?>: <?php echo $this->user->email; ?></p>
<div class="registration<?php echo $this->pageclass_sfx?>">
	<form id="gencell-user-registration" action="<?php echo JRoute::_('index.php?option=com_gencellpharma&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
		<?php // Iterate through the form fieldsets and display each one. ?>
		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
			<?php $fields = $this->form->getFieldset($fieldset->name);?>
			<?php if (count($fields)):?>
				<fieldset>
				<?php // If the fieldset has a label set, display it as the legend. ?>
				<?php if (isset($fieldset->label)): ?>
					<legend><?php echo JText::_($fieldset->label);?></legend>
				<?php endif;?>
				<?php // Iterate through the fields in the set and display them. ?>
				<?php foreach ($fields as $field) : ?>
					<?php // If the field is hidden, just display the input. ?>
					<?php if ($field->hidden): ?>
						<?php echo $field->input;?>
					<?php else:?>
						<div class="control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							</div>
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
					<?php endif;?>
				<?php endforeach;?>
				</fieldset>
			<?php endif;?>
		<?php endforeach;?>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER');?></button>
				<a class="btn" href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
				<input type="hidden" name="option" value="com_gencellpharma" />
				<input type="hidden" name="task" value="registration.register" />
			</div>
		</div>
		<?php echo JHtml::_('form.token');?>
	</form>
</div>