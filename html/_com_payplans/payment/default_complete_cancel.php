<?php
/**
* @copyright	Copyright (C) 2009 - 2015 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	Frontend
* @contact 		support+payplans@readybytes.in
*/
if(defined('_JEXEC')===false) die();
?>
	<h1>Cotisation à la SFGM-TC</h1>
	<h2>
		<?php echo XiText::_('COM_PAYPLANS_PAYMENT_CANCEL');?>
	</h2>
	<div><hr ></div>

	<div class="text-center">
		<h4>
			<?php echo XiText::_('COM_PAYPLANS_PAYMENT_CANCEL_MSG');?>
		</h4>

		<div>
			<?php // echo XiText::_('COM_PAYPLANS_PAYMENT_PAYNOW_MSG'); ?>
			<div>&nbsp;</div>
			<a class="btn btn-default btn-primary btn-lg" href="<?php echo XiRoute::_('index.php?option=com_payplans&view=invoice&task=confirm&invoice_key='.$invoice->getKey()); ?>">
				<?php echo XiText::_('COM_PAYPLANS_PAYMENT_PAYNOW')?>
			</a>
			<?php // $style = array('class'=> 'btn btn-default btn-lg');?>
			<?php // echo PayplansHtml::_('email.link', XiText::_('COM_PAYPLANS_ELEMENT_EMAIL'), $style);?>
		</div>
	</div>
	<div>&nbsp;</div>
<?php
