<?php
/**
* @copyright	Copyright (C) 2009 - 2016 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	Offlinepay
* @contact 		support+payplans@readybytes.in
*/
if(defined('_JEXEC')===false) die();
?>
<?php //XITODO: clean javascript?>
<script type="text/javascript">
function offlineChangeAction()
{
	document.getElementById('payplans_payment_action').value = 'cancel';
	return true;
}
</script>

<style>
	label[style] {
		display: block !important;
	}
</style>

<form action="<?php echo $posturl ?>" method="post" name="site<?php echo $this->getName(); ?>Form" class="form-horizontal">
	<?php $fieldset = $transaction_html->getFieldset('gateway_params');?>
	<?php $class 	= $fieldset['Payplans_form_gateway_params_from']->group.$fieldset['Payplans_form_gateway_params_from']->fieldname; ?>
	<div class="row form-group control-group <?php echo $class;?>">
		<div class = "col-sm-4">
				<div class="control-label">
					<?php echo $fieldset['Payplans_form_gateway_params_from']->label; ?>
				</div>
		</div>

		<div class="controls col-sm-4">
			<?php echo $fieldset['Payplans_form_gateway_params_from']->input; ?>
		</div>
	</div>

	<?php $class = $fieldset['Payplans_form_gateway_params_id']->group.$fieldset['Payplans_form_gateway_params_id']->fieldname; ?>
	<div class="row form-group control-group <?php echo $class;?>">
		<div class = "col-sm-4">
			<div class="control-label">
				<?php echo $fieldset['Payplans_form_gateway_params_id']->label; ?>
			</div>
		</div>

		<div class="controls col-sm-4">
			<?php echo $fieldset['Payplans_form_gateway_params_id']->input; ?>
		</div>

		<div class="col-sm-12">
			<p><span class="small">Pour nous permettre d'identifier votre paiement rapidement, merci de saisir une référence sous la forme : <br />
				<em>Adhésion à la SFGM-TC de [votre prénom] [votre nom] chèque : [n° de votre chèque]</em>.</span></p>
		</div>
	</div>

	<div class="row form-group control-group">
    <div class = "col-sm-4">
    	<div class="control-label"><?php echo XiText::_('COM_PAYPLANS_APP_OFFLINE_TRANSACTION_AMOUNT_LABEL');?></div>
    </div>
	  <div class="controls col-sm-4"><?php echo $this->_render('partial_amount', compact('currency', 'amount'), 'default');?></div>
  </div>

	<!--
	<div class="row form-group control-group">
			<div class = "col-sm-4">
		    <div class="control-label">
					<?php echo XiText::_('COM_PAYPLANS_APP_OFFLINE_BANK_NAME_LABEL');?>
				</div>
			</div>
	    <div class="controls col-sm-12">
	       	<?php echo $this->getAppParam('bankname', false);?>
	    </div>
  </div>
	-->

	<div class="row form-group control-group">
		<!--
		<div class = "col-sm-4">
  		<div class="control-label">
				<?php echo XiText::_('COM_PAYPLANS_APP_OFFLINE_ACCOUNT_NUBMER_LABEL')?>
			</div>
  	</div>
		-->
    <div class="controls col-sm-12">
     		<?php echo $this->getAppParam('account_number', false);?>
    </div>
  </div>

<input type="hidden" name="payment_key" value="<?php echo $payment_key;?>" />

<?php $class = $fieldset['Payplans_form_gateway_params_amount']->group.$fieldset['Payplans_form_gateway_params_amount']->fieldname; ?>
	<div class="row form-group control-group <?php echo $class;?>">
			<div class="controls">
				<?php echo $fieldset['Payplans_form_gateway_params_amount']->input; ?>
			</div>
	</div>

	<div class="col-sm-offset-5">
		<button type="submit" id="payplans-payment" class="btn btn-primary" name="payplans_payment_btn" onclick="this.onclick=function(){return false;}"><?php echo XiText::_('COM_PAYPLANS_PAYMENT')?></button>
		<button type="submit" id="payplans-payment-cancel" class="btn btn-default" name="payplans_payment_cancel_btn" onClick="offlineChangeAction()"><?php echo XiText::_('COM_PAYPLANS_PAYMENT_CANCEL_BUTTON');?></button>
		<input type="hidden" id="payplans_payment_action" name="action" value="success" />
	</div>

</form>
<?php
