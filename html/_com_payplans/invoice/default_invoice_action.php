<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		PayPlans
* @subpackage	pdfInvoice
* @contact 		payplans@readybytes.in
*/
if(defined('_JEXEC')===false) die();

//render modules that are using this position
?>
<div class="pp-invoice-download clearfix" style="padding:0 15px;" >
<?php
        $position = 'pp-invoice-thanks-action';
        echo $this->loadTemplate('partial_position',compact('plugin_result','position'));
        ?>
</div>
<?php
