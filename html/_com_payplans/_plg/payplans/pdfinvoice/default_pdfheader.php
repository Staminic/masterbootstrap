<?php 
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license	    GNU/GPL, see LICENSE.php
* @package	    PayPlans
* @subpackage	pdfInvoice
* @contact 	    payplans@readybytes.in
*/
if(defined('_JEXEC')===false) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo "pdfInvoice";?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<style type="text/css">
<?php echo file_get_contents(__DIR__.DS.'pdf.css'); ?>
</style>
</head>
<body>