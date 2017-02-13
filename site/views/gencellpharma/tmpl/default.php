<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gencellpharma
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
JHtml::_('bootstrap.framework');
$document = JFactory::getDocument();
$document->addStyleSheet($this->baseurl . '/components/com_gencellpharma/assets/css/gencellpharma.css?v=1.1');
$document->addScript($this->baseurl . '/components/com_gencellpharma/assets/js/moment-with-locales.min.js');
$document->addScript($this->baseurl . '/components/com_gencellpharma/assets/js/underscore-min.js');
$document->addScript($this->baseurl . '/components/com_gencellpharma/assets/js/knockout-3.4.1.js');
$document->addScriptDeclaration('var base = \'' . JURI::base() . '\';');
$isEnt = $this->userGencell->user_type_id == 2;
if ($isEnt) {
	$document->addStyleSheet($this->baseurl . '/components/com_gencellpharma/assets/css/bootstrap-grid.css?v=1.0');
	$document->addScript($this->baseurl . '/components/com_gencellpharma/assets/js/gencellpharma-enterprise.js');
} else {
	$document->addScript($this->baseurl . '/components/com_gencellpharma/assets/js/gencellpharma.js');
}
$userToken = JSession::getFormToken();
?>
<div class="container-fluid">
	<div class="page-header">
		<?php if ($isEnt) :?>
		<h1><?php echo $this->enterprise->nombre;?></h1>
		<?php endif;?>
		<h3><?php echo JText::_('COM_GENCELLPHAR_WELCOME');?>: <?php echo $this->user->name?> <small><a class="text-error" href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&' . $userToken . '=1'); ?>">(<i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo JText::_('COM_GENCELLPHAR_EXIT');?>)</a></small></h3>
	</div>
	<?php if ($isEnt): ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th><?php echo JText::_('COM_GENCELLPHAR_PATIENT_DOCUMENT');?></th>
				<th><?php echo JText::_('COM_GENCELLPHAR_PATIENT_NAME');?></th>
			</tr>
		</thead>
		<tbody data-bind="foreach: patients">
			<tr class="puntero" data-bind="click: $root.loadResultList">
				<td data-bind="text: $index() + 1"></td>
				<td data-bind="text: documento"></td>
				<td data-bind="text: nombre"></td>
			</tr>
		</tbody>
	</table>
	<?php else:?>
	<section>
		<?php echo JText::_('COM_GENCELLPHAR_INTRO_TEXT_1');?>
		<dl>
			<dt><?php echo JText::_('COM_GENCELLPHAR_REGISTER_NAME_LBL');?></dt>
			<dd><?php echo $this->user->name;?></dd>
			<dt><?php echo JText::_('COM_GENCELLPHAR_REGISTER_DOCUMENT_LBL');?></dt>
			<dd><?php echo $this->userGencell->documento;?></dd>
			<dt><?php echo JText::_('COM_GENCELLPHAR_REGISTER_EMAIL_LABEL');?></dt>
			<dd><?php echo $this->user->email;?></dd>
		</dl>
	</section>
	<div class="well">
		<p><?php echo JText::_('COM_GENCELLPHAR_DOWNLOAD_RESULT');?></p>
		<ul class="list-group" data-bind="foreach: resultList">
			<li class="list-group-item">
				<a class="tablet-ok" target="_blank" data-bind="attr: {href: 'index.php?option=com_gencellpharma&view=pdf&format=pdf&idr=' + $data.id}"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo JText::_('COM_GENCELLPHAR_TEST_RESULT');?> (<span  data-bind="text: upload_date"></span>)</a>
				<a class="tablet-notok" href="#" data-bind="click: $root.verResultado"><i class="fa fa-download" aria-hidden="true"></i> <?php echo JText::_('COM_GENCELLPHAR_TEST_RESULT');?> (<span  data-bind="text: upload_date"></span>)</a>
			</li>
		</ul>
	</div>
	<?php endif;?>
</div>
<div id="loading" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<h3>cargando...</h3>
				<div class="progress">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if ($isEnt): ?>
<div class="modal ancho fade" id="resultListModal" tabindex="-1" role="dialog" aria-labelledby="resultListModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="resultListModalLabel"><?php echo JText::_('COM_GENCELLPHAR_RESULT_LIST_TITLE');?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-4 col-md-2 col-xl-1">
						<ul class="list-group" data-bind="foreach: resultList">
							<li class="list-group-item"><a href="#" data-bind="text: upload_date, click: $root.verResultado"></a></li>
						</ul>
					</div>
					<div class="col-sm-8 col-md-10 col-xl-11">
						<!-- ko if: resultPath -->
						<iframe class="modal-frm" data-bind="attr: {src: resultPath}"></iframe>
						<!-- /ko -->
						<!-- ko ifnot: resultPath -->
						<h1 class="text-center"><i class="fa fa-medkit" aria-hidden="true"></i></h1>
						<!-- /ko -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div class="modal ancho fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="resultModalLabel"><?php echo JText::_('COM_GENCELLPHAR_RESULT_TITLE');?></h4>
			</div>
			<div class="modal-body">
				<iframe class="modal-frm" data-bind="attr: {src: resultPath}"></iframe>
			</div>
		</div>
	</div>
</div>
<?php endif;?>