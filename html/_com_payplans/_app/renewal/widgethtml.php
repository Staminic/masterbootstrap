<?php
/**
 * @copyright	Copyright (C) 2009 - 2016 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @package		PayPlans
 * @subpackage	Renewal
 * @contact 	support+payplans@readybytes.in


 */
if(defined('_JEXEC')===false) die(); ?>
<?php

	// If order is expired then do not allow to renew
	$order = $subscription->getOrder(PAYPLANS_INSTANCE_REQUIRE);
	if(in_array($order->getStatus(), array(PayplansStatus::ORDER_EXPIRED))){
		return true;
	}

?>

<!-- display renew link -->
<?php if (PayplansStatus::SUBSCRIPTION_EXPIRED == $subscription->getStatus()) { ?>
	<div class="well" style="max-width: 60%;">
		<p class="text-left"><strong>Important :</strong> avant de renouveller votre cotisation, merci de vérifier que vos informations d'inscription sont à jour dans <a href="/editer-votre-profil">votre profil</a>.</p>
		<a class="btn btn-success" href="<?php echo XiRoute::_('index.php?option=com_payplans&view=order&task=trigger&event=onPayplansOrderRenewalRequest&subscription_key='.$subscription->getKey());?>">
			<i class="fa fa-white fa-repeat"></i>&nbsp;<?php echo XiText::_("COM_PAYPLANS_ORDER_RENEW_LINK");?>
		</a>
	</div>
<?php } ?>
