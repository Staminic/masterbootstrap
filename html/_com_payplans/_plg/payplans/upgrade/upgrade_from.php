<?php
/**
 * @copyright	Copyright (C) 2009 - 2016 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @package		PayPlans
 * @subpackage	Upgrade App
 * @contact 	support+payplans@readybytes.in


 */
if(defined('_JEXEC')===false) die();
?>
<div id="payplans" class="payplans">

<div class="upgrade-options">
	 <div class="well">
		<div class="row">
			<div class="col-sm-6">
				<label><small><?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_PREVIOUS_PLAN');?></small></label>
		    	<p><?php echo $subscription->getTitle(); ?></p>
				<p> <?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_PREVIOUS_PAYMENT');?>
					<strong>
					<?php
						$amount   = $subscription->getTotal();
						$currency = $order->getCurrency();
						echo $this->_render('partial_amount', compact('currency', 'amount'), 'default');
					?>
					</strong>
				</p>
			</div>
			<div class="col-sm-6">
				<label><small><?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_NEW_PLAN');?></small></label>

				<?php if(empty($upgrade_to)):?>
						<div class="error" style="margin-left:-70px; margin-top:10px;"><?php echo XiText::_('PLG_PAYPLANS_UPGRADE_NO_UPGRADES_AVAILABLE_FOR_THIS_PLAN');?></div>
				<?php else :?>
					<select name="upgrade_to" id="payplans-upgrade-to" onChange="payplans.apps.upgrade.getUpgradedDetails(this.value, '<?php echo $sub_key;?>')">
					<option value="0" selected="selected" disabled="disabled"><?php echo XiText::_('PLG_PAYPLANS_UPGRADE_SELECT_NEW_PLAN');?></option>
					<?php foreach($upgrade_to as $plan) : ?>
						<option value="<?php echo $plan->getId();?>"><?php echo $plan->getTitle();?></option>
					<?php endforeach;?>
					</select>
				<?php endif;?>

				<p class="payplans-upgrade-payment-details"><?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_PREVIOUS_PAYMENT');?><strong class="payplans-upgrade-regular-price"></strong></p>
			</div>
		</div>
	</div>

	<div class="payplans-upgrade-payment-details">
		<p><?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_PAYMENT_DETAILS');?></p>
		<div>
			<table class="table table-condensed">

		              <tbody>
		                <tr>

		                  <td><?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_NEW_PRICE');?></td>
		                  <td class="payplans-upgrade-regular-price"></td>
		                </tr>
		                <tr>

		                  <td><?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_NOT_UTILIZED_PAYMENT');?></td>
		                   <td class="payplans-upgrade-unutilized-amount"></td>
		                </tr>
						<tr style="display: none;">
							<td><?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_NOT_UTILIZED_TAX');?></td>
							<td class="payplans-upgrade-unutilized-tax"></td>
						</tr>
		                <tr>

		                  <td><strong><?php echo XiText::_('COM_PAYPLANS_UPGRADES_DETAILS_NEW_CURRENT_PAYABLE_AMOUNT');?></strong></td>
		                    <td class="payplans-upgrade-payable-amount"><strong></strong></td>
		                </tr>

			</tbody>
		    </table>
		</div>
	</div>
</div>

<?php if(XiFactory::getApplication()->isAdmin()):?>
<div class="clearfix">
	<script type="text/javascript">
		payplans.jQuery(document).ready(function($){
				payplans.apps.upgrade.hideInfoButtons();
			});
	</script>
	<div>
		<div class="upgrade-info" id="upgrade-info-free">
			<?php echo XiText::_('COM_PAYPLANS_UPGRADES_FROM_BACKEND_FREE_UPGARDE_DETAILS');?>
		</div>
		<div class="upgrade-info" id="upgrade-info-offline">
			<?php echo XiText::_('COM_PAYPLANS_UPGRADES_FROM_BACKEND_OFFLINE_UPGARDE_DETAILS');?>
		</div>
		<div class="upgrade-info" id="upgrade-info-partial">
			<?php echo XiText::_('COM_PAYPLANS_UPGRADES_FROM_BACKEND_PARTIAL_UPGARDE_DETAILS');?>
		</div>
	</div>
	<input type="hidden" id="upgrade-type" value="" />
</div>
<?php endif;?>

</div>
<?php
