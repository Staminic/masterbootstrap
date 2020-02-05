<?php 
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license	    GNU/GPL, see LICENSE.php
* @package	    PayPlans
* @subpackage	pdfInvoice
* @contact 	    payplans@readybytes.in
*/

defined('_JEXEC') or die('Restricted access'); ?>

<!-- Script to reset the fields and post the values through hidden variables-->
<script type="text/javascript">
	function resetVariables(event)
	{
		var pdfinvoice_invoiceKey =  document.getElementById('pdfinvoice_invoiceKey').value;
		var pdfinvoice_txnDateFrm =  document.getElementById('pdfinvoice_txnDateFrm').value;
		var pdfinvoice_txnDateTo  =  document.getElementById('pdfinvoice_txnDateTo').value;

		//if all fields are left blank
		if(pdfinvoice_invoiceKey == "" && pdfinvoice_txnDateFrm == "" && pdfinvoice_txnDateTo == ""){
			alert("<?php echo XiText::_('PLG_PAYPLANS_PDFINVOICE_ENTER_EITHER_KEY_OR_DATES');?>");
			event.preventDefault();
			return false;
		}
		document.getElementById("invoiceForm").submit();
	}
</script>
<div class="tab-pane" id="pdfinvoice">
<form action="<?php echo JRoute::_( 'index.php?option=com_payplans&view=reports&action=adminPdfInvoice&pdfinvoice_deleteFiles=1',false ); ?>" method="post" id="invoiceForm" name="invoiceForm">
<div class="row-fluid form-horizontal">	

		<div class="control-group">
			<div class="control-label">Invoice Key:</div>
			<div class="controls">
				<input type="text" value="" size="20" name="pdfinvoice_invoiceKey" id="pdfinvoice_invoiceKey">
			</div>
		</div>
		
		<h6>Transaction Date</h6>
				
		<div class="control-group">
			<div class="control-label">From:</div>
				
			<div class="controls">
				<?php 
			          echo JHTML::_('behavior.calendar');
			          echo JHTML::_('calendar', '', 'pdfinvoice_txnDateFrm', 'pdfinvoice_txnDateFrm','%Y-%m-%d', array('class'=>'inputbox', 'maxlength'=>'19'));
		        ?>
				
			</div>
		</div>
		
		<div class="control-group">
			<div class="control-label">To:</div>
				
			<div class="controls">
				<?php 
			          echo JHTML::_('behavior.calendar');
			          echo JHTML::_('calendar', '', 'pdfinvoice_txnDateTo', 'pdfinvoice_txnDateTo','%Y-%m-%d', array('class'=>'inputbox', 'maxlength'=>'19'));
		        ?>	
		        <button  onclick="resetVariables(event)" name="save" id="submitbtn" class="<?php echo (PAYPLANS_JVERSION_30)?'':'offset2';?> btn btn-primary" title="<?php echo XiText::_('PLG_PAYPLANS_PDFINVOICE_DOWNLOAD_PDF_BTN');?>">
				<i class="icon-download icon-white"></i>&nbsp;<?php echo XiText::_('PLG_PAYPLANS_PDFINVOICE_INVOICE_DOWNLOAD');?>
				</button>
			</div>
		</div>
</div>
	
<?php  echo JHTML::_ ( 'form.token' ); ?>
</form>
</div>
<?php 