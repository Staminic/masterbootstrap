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
		<?php echo XiText::_('COM_PAYPLANS_PAYMENT_PAY_HEADING');?>
	</h2>
	<hr >

<?php foreach($result as $html):
	if(is_bool($html)==false):
		echo $html;
	endif;
endforeach;
?>
