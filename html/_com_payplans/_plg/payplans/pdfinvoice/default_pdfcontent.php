<?php
/**
* @copyright	Copyright (C) 2009 - 2015 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license	    GNU/GPL, see LICENSE.php
* @package	    PayPlans
* @subpackage	pdfInvoice
* @contact 	    support+payplans@readybytes.in
*/
if(defined('_JEXEC')===false) die();

if(isset($transaction)){
	$payment    = $transaction->getPayment(PAYPLANS_INSTANCE_REQUIRE);
}
$currency 		= $invoice->getCurrency();
$invoice_key    = $invoice->getKey();
$created_date   = PayplansHelperFormat::date($invoice->getCreatedDate());
$payment 		= $invoice->getPayment();


//get paid-on date from wallet entry
$modification_date = is_null($record->created_date)?$record->created_date:PayplansHelperFormat::date($record->created_date);

// status of invoice
$class = '';
switch($invoice->getStatus()){
	case PayplansStatus::INVOICE_CONFIRMED :
		$class = 'label-important';
		break;
	case PayplansStatus::INVOICE_PAID :
		$class = 'label-success';
		break;

	case PayplansStatus::INVOICE_REFUNDED :
		$class = 'label-inverse';
		break;

	default:
		$pending_text = XiText::_('COM_PAYPLANS_STATUS_NONE');
		$class = 'label-warning';
		break;
}

$discountables = $invoice->getModifiers(array('serial'=>array(PayplansModifier::FIXED_DISCOUNTABLE,PayplansModifier::PERCENT_DISCOUNTABLE, PayplansModifier::PERCENT_OF_SUBTOTAL_DISCOUNTABLE), 'invoice_id'=>$invoice->getId()));
$discountables = PayplansHelperModifier::_rearrange($discountables);

$nonTaxables = $invoice->getModifiers(array('serial'=>array(PayplansModifier::FIXED_NON_TAXABLE,PayplansModifier::PERCENT_NON_TAXABLE, PayplansModifier::PERCENT_OF_SUBTOTAL_NON_TAXABLE), 'invoice_id'=>$invoice->getId()));
$nonTaxables = PayplansHelperModifier::_rearrange($nonTaxables);

$taxables = $invoice->getModifiers(array('serial'=>array(PayplansModifier::PERCENT_TAXABLE, PayplansModifier::PERCENT_OF_SUBTOTAL_TAXABLE), 'invoice_id'=>$invoice->getId()));
$taxables = PayplansHelperModifier::_rearrange($taxables);

?>
<div class="invoice" style="page-break-after:always; display:block;">
<table class="header" width="100%">
	<tr>
		<td width="80%">
			<?php if(XiFactory::getConfig()->companyLogo):?>
				<div style="max-width:150px; width:150px;">
					<?php echo "<img style='width:100%;' src=".JPATH_ROOT.DS.XiFactory::getConfig()->companyLogo.">";?>
				</div>
			<?php endif;?>
			<p>&nbsp;</p>
			<h3><?php echo XiFactory::getConfig()->companyName; ?></h3>
			<p>
				<?php echo XiFactory::getConfig()->companyAddress;?><br />
				<?php echo XiFactory::getConfig()->companyCityCountry;?><br />
				<?php echo XiFactory::getConfig()->companyPhone;?><br />
			</p>
		</td>
		<td width="20%" align="center">
			<p class="label <?php echo $class;?>">
				<?php echo ($invoice->getStatus()==PayplansStatus::NONE) ? $pending_text : $invoice->getStatusName();?>
			</p>
			<p style="font-size: 10px;">
				<?php if($invoice->getStatus() == PayplansStatus::INVOICE_PAID):?>
				<?php echo XiText::_('COM_PAYPLANS_INVOICE_PAID_ON'), ' ' ,$modification_date; ?>
				<?php else:?>&nbsp;
				<?php endif;?>
			</p>
		</td>
  </tr>
</table>

<table class="billto" width="100%">
  <tr>
    <td width="100%" align="left" valign="top">
			<?php echo XiHelperTemplate::partial('default_partial_extra_details', array('invoice'=>$invoice)); ?>
			<?php if(($invoice->getStatus() == PayplansStatus::INVOICE_PAID)):?>
				<?php if(isset($payment) && ($payment instanceof PayplansPayment) && $payment->getId()){
						echo XiText::_('COM_PAYPLANS_INVOICE_PAYMENT_METHOD').': <strong>'.$payment->getAppName().'</strong>';
						// echo XiText::_('COM_PAYPLANS_INVOICE_PAYMENT_METHOD').': <strong>Paiement par chèque ou par virement</strong>';
						} else {
							 	echo XiText::_('COM_PAYPLANS_TRANSACTION_PAYMENT_GATEWAY_NONE');
						}
				?>
			<?php endif;?>
    </td>
  </tr>
</table>

<table class="particulars" width="100%">
  <thead>
      <tr>
          <th width="80%" align="left"><?php //echo XiText::_('COM_PAYPLANS_INVOICE_DESCRIPTION'); ?></th>
          <th width="20%" align="right"><?php echo XiText::_('COM_PAYPLANS_INVOICE_AMOUNT'); ?></th>
      </tr>
  </thead>

  <tbody>
    <tr>
		<td>
			<div><?php echo XiText::_('COM_PAYPLANS_INVOICE_PRICE'); ?></div>
		</td>
		<td style="text-align:right;">
			<span>
 					<?php echo XiHelperTemplate::partial('default_partial_amount',array('currency'=>$currency,'amount'=>$invoice->getSubtotal()));?>
			</span>
		</td>
	</tr>

<?php   $modifiers = $invoice->getModifiers();
		$modifiers = PayplansHelperModifier::_rearrange($modifiers);
		foreach ($modifiers as $modifier):?>
			<?php if(in_array($modifier->getSerial(),
						array(	PayplansModifier::FIXED_DISCOUNTABLE, PayplansModifier::PERCENT_DISCOUNTABLE,
								PayplansModifier::PERCENT_OF_SUBTOTAL_DISCOUNTABLE,
								PayplansModifier::FIXED_DISCOUNT,PayplansModifier::PERCENT_DISCOUNT
								)
					)):?>
		<tr>
			<td>
				 <div><?php echo XiText::_($modifier->get('message'));?></div>
            </td>
			<td style="text-align:right;">
				<span style="font-size: 11px;"><?php echo ($modifier->_modificationOf< 0) ? '(-)&nbsp;' : '(+)&nbsp;'; ?></span>
				<span><?php echo str_replace('-', '' ,PayplansHelperFormat::displayAmount($modifier->_modificationOf)); ?></span>
			</td>
		</tr>
		<?php endif; ?>

		<?php if(in_array($modifier->getSerial(),
						array(PayplansModifier::PERCENT_TAXABLE,PayplansModifier::PERCENT_OF_SUBTOTAL_TAXABLE,
								PayplansModifier::FIXED_TAX,PayplansModifier::PERCENT_TAX,
						)
			 )):?>

	 	  <tr>
			<td>
				<div><?php echo $modifier->get('message')?></div>
			</td>
			<td style="text-align:right;">
				<span style="font-size: 11px;"><?php echo ($modifier->_modificationOf< 0) ? '(-)&nbsp;' : '(+)&nbsp;'; ?></span>
				<span><?php echo str_replace('-', '' ,PayplansHelperFormat::displayAmount($modifier->_modificationOf)); ?></span>
			</td>
		  </tr>
  		 <?php endif;?>
  		  <?php if(in_array($modifier->getSerial(), array(PayplansModifier::FIXED_NON_TAXABLE,PayplansModifier::PERCENT_NON_TAXABLE,PayplansModifier::PERCENT_OF_SUBTOTAL_NON_TAXABLE,PayplansModifier::FIXED_NON_TAXABLE_TAX_ADJUSTABLE))):?>
		 <tr>
			<td>
				<div><?php echo $modifier->get('message')?></div>
			</td>
			<td style="text-align:right;">
				<span style="font-size: 11px;"><?php echo ($modifier->_modificationOf< 0) ? '(-)&nbsp;' : '(+)&nbsp;'; ?></span>
				<span><?php echo str_replace('-', '' ,PayplansHelperFormat::displayAmount($modifier->_modificationOf)); ?></span>
			</td>
		</tr>
	  <?php endif;endforeach;?>

    	<tr class="last">
      		<td>
        		<strong><?php echo XiText::_('COM_PAYPLANS_INVOICE_TOTAL'); ?></strong>
     		 </td>
     		 <td style="text-align:right;">
      			<strong><?php echo XiHelperTemplate::partial('default_partial_amount',array('currency'=>$currency,'amount'=>$invoice->getTotal()));?></strong>
      		</td>
    	</tr>
  </tbody>
</table>

<!--  Notes Section -->
<?php if(!empty(XiFactory::getConfig()->note)):?>
    <div style="margin-top:40px;">
     	<h5 class="notes"><?php echo XiText::_('COM_PAYPLANS_INVOICE_NOTES');?></h5>
      <small><?php echo XiFactory::getConfig()->note;?></small>
    </div>
<?php endif;?>
</div>
