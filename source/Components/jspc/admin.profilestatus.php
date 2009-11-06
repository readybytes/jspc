<?php
/**
 * Joomla! 1.5 component profilestatus
 *
 * @version $Id: controller.php 2009-07-01 01:02:25 svn $
 * @author Meenal Devpura
 * @package Joomla
 * @subpackage profilestatus
 * @license GNU/GPL
 *
 * Joomla component for jomsocial to show completion of profile
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'profilestatus.php' );

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

$controller	= new ProfilestatusController( );
//print_r("<br /> in profilestatus.php file ");
//print_r($controller);
// Perform the Request task
$task = JRequest::getCmd('task');
//print_r("task = ".$task." to be done ");
if($task == '')
{
	JRequest::setVar('task', 'display');
	$task='display';
}
$controller->execute($task);
//$controller->redirect();
// NOW RUN
?>