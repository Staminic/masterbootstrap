<?php
/**
* @copyright	Copyright (C) 2009 - 2015 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	Frontend
* @contact 		support+payplans@readybytes.in
*/
if(defined('_JEXEC')===false) die(); ?>

<div class="pp-dashboard">
<?php if(XiFactory::getUser()->id): ?>
	<div class="clearfix">

			<div class="pull-left text-left">
				<h2 class="item-title"><?php echo ucfirst($user->getRealname()); ?> (<?php echo $user->getUsername();?>)</h2>
				<ul class="list-inline text-muted text-shadow-white hidden-xs">
					<li><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_USER_EMAIL').$user->getEmail();?></li>
					<li>|</li>
					<li><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_USER_ACTIVE_SUBSCRIPTIONS').count(($user->getSubscriptions(PayplansStatus::SUBSCRIPTION_ACTIVE)));?></li>
				</ul>
			</div>
			<br class="visible-xs"/><br class="visible-xs"/>
			<div class="pull-right text-right clearall">
				<?php
				$link		= JURI::getInstance()->toString();
				$return		= base64_encode($link);
				?>
				<a class="btn btn-default" href="<?php echo XiHelperJoomla::getLogoutLink(); ?>">
					<?php echo XiText::_('COM_PAYPLANS_DASHBOARD_ACTION_LOGOUT');?>
				</a>
			</div>
		</div>
		<br />

<?php endif;?>

<?php  if(empty($subscription_records)): ?>
			<?php 	$message = XiText::_('COM_PAYPLANS_DASHBOARD_ORDER_WIDGET_USER_NOT_LOGIN');
					if(XiFactory::getUser()->id):
						$message = XiText::_('COM_PAYPLANS_DASHBOARD_ORDER_WIDGET_NO_SUBSCRIPTIONS');
			 		endif; ?>
			<div class="well text-center">
				<h3><?php echo $message;?></h3>
				<p>
					<a href="<?php echo XiRoute::_('index.php?option=com_payplans&view=plan&task=subscribe'); ?>" class="btn btn-default btn-primary">
						<?php echo XiText::_('COM_PAYPLANS_DASHBOARD_ORDER_WIDGET_ACTION_SUBSCRIBE_PLAN');?>
					</a>
				</p>
			</div>

<?php else: ?>
	<div class="tabbable tabs-left row">
		<!-- tabs links -->
		<div class="col-sm-12">
			<!-- <ul class="unstyled nav nav-tabs nav-stacked white-box"  id="payplans-dashboard-tab">
				<li class="active">
					<a class="tabs" data-toggle="tab" href="#my-purchases"><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_USER_PURCHASE');?></a>
				</li>
				<?php if($display_myaccount	) :?>
				<li class="">
					<a href="#my-account"><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_USER_ACCOUNT');?> </a>
				</li>
				<?php endif;?>
			</ul> -->

			<!-- Display widgets/modules -->
			 	<?php 	$position  = 'payplans-dashboard-tab';
   						echo $this->loadTemplate('partial_position',compact('plugin_result','position'));
   				?>
		</div>

		<!-- tabs start here -->
		<div class="col-sm-12">
				<div class="tab-content">
					<?php if($display_myaccount) :?>
					<!-- 	my account tab start -->
					<div class="tab-pane" id="my-account">
						<div class="row">
							<?php echo $this->loadTemplate('template_right'); ?>
							<?php echo $this->loadTemplate('template_footer');?>
						</div>
					</div>
					<!-- 	my account tab finish -->
					<?php endif;?>

					<!-- 	my purchase tab start -->
					<div class="tab-pane active" id="my-purchases">
						<?php
							krsort($subscription_records);
							foreach($subscription_records as $record):

								$subscription 			= PayplansSubscription::getInstance($record->subscription_id,null, $record);
								$subscription_key 		= $subscription->getKey();

								$class		 			= '';
								$isActive	 			= false;
								$isExpire	 			= false;
								$isHold		 			= false;
								$isNotPaid 				= false;

								switch($subscription->getStatus()) {

									case PayplansStatus::SUBSCRIPTION_ACTIVE :
										$class			= 'success';
										$isActive		= true;
										break;
									case PayplansStatus::SUBSCRIPTION_EXPIRED :
										$class			='danger';
										$isExpire 		= true;
										break;
									case PayplansStatus::SUBSCRIPTION_HOLD :
										$class			='warning';
										$isHold 		= true;
										break;
									default :
										$class 		 	='default';
										$isNotPaid 		= true;
										break;
								}
							?>

								<div class="white-well">
									<div class="clearfix help-block">
										<?php
												if ($isExpire) {
													$alertmessage 	= XiText::_('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_EXPIRE_ALERT');
													$renewalapp 	= PayplansHelperApp::getApplicableApps('Renewal', $subscription);
													if(!empty($renewalapp)){
														$alertmessage = $alertmessage." ".XiText::_('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_RENEWAL_ALERT');
													}

													//Displaying Message if subscription is exipred
													// echo '<p class="alert alert-danger">'.$alertmessage.'</p>';
													echo '<p class="alert alert-danger">Votre adhésion a expiré. Merci de la renouveler.</p>';
												}

												$order 		= $subscription->getOrder(PAYPLANS_INSTANCE_REQUIRE);
												if($order->isRecurring() && ($order->getStatus() == PayplansStatus::ORDER_COMPLETE) && ($subscription->getStatus() == PayplansStatus::SUBSCRIPTION_ACTIVE))
												{
													// if next payment is expected then display the relevant date and amount
													$paidCounter   	= $order->getRecurringInvoiceCount();
													$counter 		= $order->getRecurrenceCount();
													 if(($counter > $paidCounter) || ($counter == 0)){
													 	$invoice	 = $order->getLastMasterInvoice(PAYPLANS_INSTANCE_REQUIRE);
					 									$amount		 = $invoice->getTotal($paidCounter + 1);
					 									$currency    = $order->getCurrency();
					 									$amount_html = $this->loadTemplate('partial_amount', compact('currency', 'amount'));
					 									?>
					 									<div class="alert alert-warning fad in">
						    								<button type="button" class="close" data-dismiss="alert">&times;</button>
						    								<?php echo XiText::sprintf('COM_PAYPLANS_SUBSCRIPTION_NEXT_EXPECTED_PAYMENT', $amount_html, PayplansHelperFormat::date($subscription->getExpirationDate()))?>
					    								</div>
												<?php }
												}
										?>

										<div class="clearfix">
											<h3 class="item-title pull-left payplans-wordbreak"><?php echo $subscription->getTitle()?></h3>

											<div class="pull-right item-status">
												<?php echo '<span class="small label label-'.$class.'" title="'.$subscription->getStatusName().'">'.str_ireplace('subscription - ', '', $subscription->getStatusName()).'</span>';?>
											</div>

										</div>

											<small class="hidden-xs text-muted"><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_ID').$subscription_key;?></small>

									</div>

										<table class="table">
											<tbody>
											<tr>
												<td><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_PRICE');?></td>
												<td><?php
															$currency 	= $subscription->getOrder(PAYPLANS_INSTANCE_REQUIRE)->getCurrency();
															$recurring  = $subscription->isRecurring();
															if($recurring)
															{
																if(in_array($recurring, array(PAYPLANS_RECURRING_TRIAL_1, PAYPLANS_RECURRING_TRIAL_2))): ?>
																	<span>
																		<?php $amount   = $subscription->getPrice(PAYPLANS_RECURRING_TRIAL_1);?>
																		<?php echo $this->loadTemplate('partial_amount', compact('currency', 'amount'));?>
																	</span>
																	<span>
																		<?php echo XiText::sprintf('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_CONFIRM_FIRST_CHARGABLE_AMOUNT', PayplansHelperFormat::planTime($subscription->getExpiration(PAYPLANS_RECURRING_TRIAL_1)));?>
																	</span><br/>

																		<?php if($recurring == PAYPLANS_RECURRING_TRIAL_2):?>
																			<span>
																				<?php $amount = $subscription->getPrice(PAYPLANS_RECURRING_TRIAL_2);?>
																				<?php echo $this->loadTemplate('partial_amount', compact('currency', 'amount'));?>
																			</span>
																			<span>
																				<?php echo XiText::sprintf('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_CONFIRM_SECOND_CHARGABLE_AMOUNT', PayplansHelperFormat::planTime($subscription->getExpiration(PAYPLANS_RECURRING_TRIAL_2)));?>
																			</span><br/>
																		<?php endif;?>

																<?php endif;?>
																<?php
																	$recurrence_count 	= $subscription->getRecurrenceCount();
																	$amount				= $subscription->getPrice(PAYPLANS_RECURRING);
																	$amountHtml 		= $this->loadTemplate('partial_amount', compact('currency', 'amount'));?>

																<?php if($recurrence_count <= 0 ) :?>
																	<span><?php echo XiText::sprintf('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_CONFIRM_FIRST_RECURRENCE_COUNT_ZERO_RECURRENCE_COUNT',$amountHtml,PayplansHelperFormat::planTime($subscription->getExpiration(PAYPLANS_RECURRING)));?></span>
																<?php else:?>
																	<span><?php echo XiText::sprintf('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_CONFIRM_FIRST_RECURRENCE_COUNT',$amountHtml,PayplansHelperFormat::planTime($subscription->getExpiration(PAYPLANS_RECURRING)), $recurrence_count);?></span>
																<?php endif;

															}else {
																$amount   = $subscription->getTotal();
																echo $this->loadTemplate('partial_amount', compact('currency', 'amount'));
															}

													?>
												</td>
											</tr>
											<tr>
												<td><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_SUBSCRIPTION_TIME');?></td>
												<td>
													<span>
													<?php if($subscription->getExpirationDate()->toString()!=null):?>
													  	<?php echo '<em>'.PayplansHelperFormat::date($subscription->getSubscriptionDate()).
													  				'</em> <span class="separator" style="text-transform: capitalize;font-weight: bold;">&nbsp;'.XiText::_('COM_PAYPLANS_ORDER_SUBSCRIPTIONS_TO').'</span> '.
													  				'<em>'.PayplansHelperFormat::date($subscription->getExpirationDate()).'</em>';

													  	?>
														<?php elseif($subscription->getSubscriptionDate()->toString()==null) :?>
														 		<?php echo XiText::_('COM_PAYPLANS_ORDER_SUBSCRIPTION_NOT_ACTIVATED'); ?>
														<?php else :?>
													  	 		<?php echo XiText::_('COM_PAYPLANS_ORDER_SUBSCRIPTION_TIME_LIFETIME'); ?>
												  		<?php endif;?>
											  		</span>

												</td>
											</tr>
											</tbody>
										</table>

									<div class="plan-buttons clearfix">
										<div class="text-right">
											<div class="pull-right">
												<?php if ( !$isNotPaid ) : ?>
													 <span class="btn-link pp-dashboard-togglemore" data-toggle="collapse" data-target="#subscription<?php echo $subscription_key; ?>" onclick ="payplans.site.dashboard.loadSubscriptionDetails('<?php echo $subscription_key;?>'); " >
													                          <span class="pp-dashboard-more"><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_MORE');?> </span>
													                          <span class="pp-dashboard-less"><?php echo XiText::_('COM_PAYPLANS_DASHBOARD_LESS');?> </span>
													            <i class="fa fa-chevron-down"> </i>
													 </span>
												<?php else: ?>
												<?php
														$order 					= $subscription->getOrder(PAYPLANS_INSTANCE_REQUIRE);
														$noneInvoices 			= $order->getInvoices(PayplansStatus::NONE);
														$confirmedInvoices 		= $order->getInvoices(PayplansStatus::INVOICE_CONFIRMED);
														$pendingInvoices 		= array_merge($noneInvoices, $confirmedInvoices);

														if ( ! empty($pendingInvoices) ):
															$invoice = array_pop($pendingInvoices); ?>
															<a href="<?php echo XiRoute::_('index.php?option=com_payplans&view=invoice&task=confirm&invoice_key='.$invoice->getKey()); ?>" style="display: none;">
																<span>
																	<i class="pp-icon-share-alt"></i>&nbsp;<?php echo XiText::_('COM_PAYPLANS_FRONT_INVOICE_PAY_NOW');?>
																</span>
															</a>
													<?php endif; ?>
												<?php endif; ?>
											</div>

											<?php if ( !$isNotPaid ) : ?>
											<div class="pull-left text-right">

												<!--  renewal button -->
												<?php
													$apps = PayplansHelperApp::getApplicableApps('Renewal', $subscription);
													foreach ($apps as $renewal) {
														echo $renewal->renderWidget($subscription->getId());
													}
												?>

												<!-- 	upgrade button -->
												<?php
													$apps = PayplansHelperApp::getApplicableApps('Upgrade', $subscription);
													foreach ($apps as $upgrade) {
														echo $upgrade->renderWidget($subscription->getId());
													}
												?>
											</div>
											<?php endif; ?>
										</div>
									</div>

									<div>&nbsp;</div>

										<div id="subscription<?php echo $subscription_key; ?>" class="collapse">

											<div class="panel-group" id="accordion2">
											  	<!--  Subscription Details -->
											  	<div class="sub-details"></div>

											  	<!-- Invoices -->
											  	<div class="panel panel-default">
												    <div class="panel-heading">
												    	<h5 data-toggle="collapse" data-target="#invoice<?php echo $subscription_key; ?>" data-parent="#accordion2" style="padding:0 5px;">
															<span class="btn-link">[+]&nbsp;<?php echo XiText::_('COM_PAYPLANS_ORDER_INVOICES');?></span>
														</h5>

												    </div>
											    	<div id="invoice<?php echo $subscription_key; ?>" class="panel-collapse collapse">
												     	<div class="panel-body">
												       		<div class="inv-details"></div>
												      	</div>
												    </div>
											  </div>
											</div>

											<div class="cancel-details"></div>

											<div class="subscription-display-action"></div>
										</div>


								</div>
							<?php endforeach; ?>
						</div>
					<!-- 	my purchase tab finish -->
				</div>
		</div>

	</div>
	<!-- tabs start finish -->

<?php endif; ?>
</div>
<script>
	jQuery('#payplans-dashboard-tab a').click(function (e) {
	  e.preventDefault();
	  jQuery(this).tab('show');
	})
</script>
