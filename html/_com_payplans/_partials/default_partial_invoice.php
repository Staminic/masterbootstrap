<?php
/**
* @copyright	Copyright (C) 2009 - 2016 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	Frontend
* @contact 		support+payplans@readybytes.in
*/
if(defined('_JEXEC')===false) die();

$invoice_key = $invoice->getKey();
$created_date = PayplansHelperFormat::date($invoice->getCreatedDate());
//get paid-on date from wallet entry
$modification_date = PayplansHelperFormat::date($invoice->getPaidDate());



$payment = $invoice->getPayment();
$currency = $invoice->getCurrency();

// status of invoice
$class = '';
switch($invoice->getStatus()){
	case PayplansStatus::INVOICE_CONFIRMED :
		$class = 'label-danger';
		break;
	case PayplansStatus::INVOICE_PAID :
		$class = 'label-success';
		break;

	case PayplansStatus::INVOICE_REFUNDED :
		$class = 'label-default';
		break;

	default:
		$pending_text = XiText::_('COM_PAYPLANS_STATUS_INVOICE_PENDING');
		$class = 'label-warning';
		break;
}

?>

<div id='invoice' class="thumbnail pp-gap-top10" style="padding: 2%;">
	<div class="pull-right text-center">
		<p>&nbsp;</p>
		<p class='label label-default <?php echo $class;?> payplans-font-inherit'>
			<?php echo ($invoice->getStatus()==PayplansStatus::NONE) ? $pending_text : $invoice->getStatusName();?>
		</p>
		<p class="small">
		<?php if($invoice->getStatus() == PayplansStatus::INVOICE_PAID):?>
			<?php echo XiText::_('COM_PAYPLANS_INVOICE_PAID_ON'), ' ' ,$modification_date; ?>
		<?php else:?>
			&nbsp;
		<?php endif;?>
		</p>
	</div>
	<div class="clearfix">
		<img style="max-width:300px; max-height:100px;" src="<?php echo JURI::base().XiFactory::getConfig()->companyLogo; ?>" />&nbsp;
		<p>&nbsp;</p>
		<p><strong><?php echo XiFactory::getConfig()->companyName; ?></strong><br />
			<?php echo XiFactory::getConfig()->companyAddress;?><br />
			<?php echo XiFactory::getConfig()->companyCityCountry; ?><br />
			<?php if(!empty(XiFactory::getConfig()->companyPhone)):?>
			<?php echo XiText::_('COM_PAYPLANS_INVOICE_PHONE_NUMBER');
						echo XiFactory::getConfig()->companyPhone; ?>
			<?php endif;?>
		</p>
	</div>

	<?php echo $this->loadTemplate('partial_extra_details', compact('invoice')); ?>
	<?php if(($invoice->getStatus() == PayplansStatus::INVOICE_PAID)):?>
		<p>
		<?php echo XiText::_('COM_PAYPLANS_INVOICE_PAYMENT_METHOD'); ?>:&nbsp;
			<strong>
				<?php
					if(isset($payment) && ($payment instanceof PayplansPayment) && $payment->getId()){
					 	echo $payment->getAppName();
						// echo 'Paiement par chèque ou par virement';
					} else {
					 	echo XiText::_('COM_PAYPLANS_TRANSACTION_PAYMENT_GATEWAY_NONE');
					}
				?>
			</strong>
		</p>
		<?php endif;?>

	<!--
			--------------------------------------------------------------------------------------------------------
						DISPLAY MODIFIRES
			--------------------------------------------------------------------------------------------------------
	 -->

	 		<table class='table pp-gap-top30' <?php echo (XiFactory::getConfig()->rtl_support) ? 'dir=rtl': '';?>>
			 			<thead>
				 			<tr>
			 					<th class='col-sm-8'><?php echo XiText::_('COM_PAYPLANS_INVOICE_DESCRIPTION'); ?></th>
			 					<th class='col-sm-4 text-right'>
			 						<span class="col-sm-10">
			 							<?php echo XiText::_('COM_PAYPLANS_INVOICE_AMOUNT'); ?>
			 						</span>
			 					</th>
				 			</tr>
			 			</thead>

			 			<tbody>
							<tr>
									<td class='col-sm-8'>
										<div><?php echo XiText::_('COM_PAYPLANS_INVOICE_PRICE'); ?></div>
									</td>
									<td  class="col-sm-4 text-right" style="vertical-align:middle;">
										<span class="col-sm-10">
											<?php  $currency = $invoice->getCurrency();
														$amount   = $invoice->getSubtotal();
														echo $this->loadTemplate('partial_amount', compact('currency', 'amount'));?>
										</span>
									</td>
							</tr>
							<?php echo $this->loadTemplate('partial_invoice_thanks_modifier', compact('invoice')); ?>

							<tr>
					 			<td class='col-sm-8'>
					 				<strong><?php echo XiText::_('COM_PAYPLANS_INVOICE_TOTAL'); ?></strong>
					 			</td>
					 			<td class="col-sm-4 text-right">
			 						<span class="col-sm-10">
			 							<strong>
							 				<?php $amount   = $invoice->getTotal();
									  		echo $this->loadTemplate('partial_amount', compact('currency', 'amount')); ?>
							  			</strong>
			 						</span>
			 					</td>
					 		</tr>
		 			</tbody>
			 </table>


		<!--  Notes Section -->
		<?php if (!empty(XiFactory::getConfig()->note)) :?>
		<div class="alert alert-block">
			<p><?php echo XiFactory::getConfig()->note;?></p>
		</div>
		<?php endif;?>
</div>

<div class='row clearfix'>
	<?php echo $this->loadTemplate('invoice_action');?>
</div>
<?php
