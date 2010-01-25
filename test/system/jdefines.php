<?php
require_once dirname(__FILE__). '/joomlaFramework.php';

// which selenium server to pick
$whichSelRC = getenv('useSelRC'); // can be local / network
if($whichSelRC == FALSE)
{
	echo "\n Environment variable not set picking up localhost as useSelRC";
	$whichSelRC = 'local';
}

require_once dirname(__FILE__). "/selRC_$whichSelRC.php";

define('JOOMLA_LOCATION',	'http://'.JOOMLA_HOST.'/@joomla.folder@/');
define('JOOMLA_FOLDER',	'@joomla.folder@');
define('JOOMLA_FTP_LOCATION', 	JPATH_BASE);

define('TIMEOUT_SEC',30000);
define('JOOMLA_ADMIN_USERNAME', 'admin');
define('JOOMLA_ADMIN_PASSWORD',	'ssv445');

//these files should have been copied by phing during setup of joomla 
define('PLG_JSPC_PKG',	JOOMLA_FTP_LOCATION.'/plg_jspc.zip');
define('MOD_JSPC_PKG',	JOOMLA_FTP_LOCATION.'/mod_jspc.zip');
define('COM_JSPC_PKG',		JOOMLA_FTP_LOCATION.'/com_jspc.zip');
define('JOMSOCIAL_PKG',		JOOMLA_FTP_LOCATION.'/com_community.zip');
