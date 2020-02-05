<?php 
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	pdfInvoice
* @contact 		payplans@readybytes.in
*/
if(defined('_JEXEC')===false) die();

$downloadUrl = XiRoute::_('index.php?option=com_payplans&view=invoice&action=sitePdfInvoice&invoice_key='.$invoice->getKey()); ?>

<a class="pull-right btn btn-primary"  onclick="payplans.url.redirect('<?php echo $downloadUrl; ?>'); return false;" >
	<h5><?php echo XiText::_('COM_PAYPLANS_FRONT_INVOICE_DOWNLOAD_LINK');?></h5>
</a> 
<?php  
