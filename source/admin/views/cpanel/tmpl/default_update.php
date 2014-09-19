<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
 	
// Broadcast added 
$version 	= new JVersion();
$suffix 	= 'jom=J'.$version->RELEASE.'&utm_campaign=JSPC-Usage&jspcv=JSPC'.JSPC_VERSION.'&dom='.JURI::getInstance()->toString(array('scheme', 'host', 'port'));?>
	<div class="row-fliud">
		<iframe class="span12" frameborder="0" src="http://www.readybytes.net/broadcast/jspc.html?<?php echo urlencode($suffix)?>"></iframe>
	</div>
<?php 

