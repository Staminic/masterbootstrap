<?php
/**
 * @copyright	Copyright (C) 2009 - 2015 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @package		PayPlans
 * @subpackage	frontend
 * @contact 	support+payplans@readybytes.in
 */
if(defined('_JEXEC')===false) die(); ?>

<div class="row">
	<table class="table table-borderless">

		<!-- Regular Price -->
		<tr>
			<td class="col-sm-6">
				<div><?php echo XiText::_('COM_PAYPLANS_ORDER_CONFIRM_REGULAR_TOTAL');?></div>
			</td>
			<td class="col-sm-6 text-right pp-payment-header-price">
				<?php //echo PayplansHelperFormat::price($subtotal);?>
				<?php $amount = $subtotal;?>
				<?php echo $this->loadTemplate('partial_amount', compact('currency', 'amount'));?>
			</td>
		</tr>
      <tr class="pp-modifier-amount"></tr>
      <?php echo $this->loadTemplate('partial_invoice_modifier', compact('invoice')); ?>

		<!-- Total Payable Amount -->
		<tr class="table-row-border">
			<td class="col-sm-6"><?php echo XiText::_('COM_PAYPLANS_ORDER_CONFIRM_AMOUNT_PAYABLE');?></td>
			<td class="col-sm-6 text-right pp-payment-header-price payable first-amount">
				<?php $amount = $total;?>
				<?php echo $this->loadTemplate('partial_amount', compact('currency', 'amount'));?>
			</td>
		</tr>

	</table>

	<div class="pp-gap-top10 pp-gap-bottom05 ">
		<?php if(XiFactory::getConfig()->enableDiscount): ?>
				<?php echo $this->loadTemplate('discount'); ?>
	    <?php endif;?>

		<?php $position = 'payplans_order_confirm_payment'; ?>
		<?php echo $this->loadTemplate('partial_position', compact('plugin_result','position'));?>
	</div>

	<div class="pp-gap-top10 pp-gap-bottom05 row">
			<div class="col-sm-6">
					<?php echo XiText::_('COM_PAYPLANS_ORDER_MAKE_PAYMENT_FROM');?>
			</div>
			<div class="col-sm-6 text-right">
				<span class="pp-payment-method">
					<?php if(!($invoice->isRecurring()) && (floatval(0) == floatval($total))):?>
							<?php  echo XiText::_('COM_PAYPLANS_ORDER_NO_PAYMENT_METHOD_NEEDED')?>
					<?php else : ?>
							<?php if(count($payment_apps) > 1):?>
								<?php echo PayplansHtml::_('select.genericlist', $payment_apps, 'app_id', 'class="input-medium"' , 'id', 'title');?>
							<?php else :
								$gateway = array_shift($payment_apps);
								echo $gateway['title'].'<input type="hidden" name="app_id" value="'.$gateway['id'].'">';?>
							<?php endif;?>
					<?php endif;?>
				</span>
			</div>
	</div>

</div><?php
