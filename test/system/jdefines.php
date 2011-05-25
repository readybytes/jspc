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

$_SERVER['HTTP_HOST'] = JOOMLA_LOCATION;

define('TIMEOUT_SEC',30000);
define('JOOMLA_ADMIN_USERNAME', 'admin');
define('JOOMLA_ADMIN_PASSWORD',	'ssv445');

//these files should have been copied by phing during setup of joomla 
define('COM_JSPC_PKG',		JOOMLA_LOCATION.'/jspc.zip');
define('JOMSOCIAL_PKG',		JOOMLA_LOCATION.'/com_community.zip');

define('COM_XIPT_PKG',		JOOMLA_LOCATION.'/test/xipt/xipt.zip');

$version = new JVersion();

define('TEST_JSPC_JOOMLA_16',($version->RELEASE === '1.6'));
define('TEST_JSPC_JOOMLA_15',($version->RELEASE === '1.5'));
