<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 *
 //@TODO : Include all helper files or other files in one common file and include that file
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//Import Joomla Dependency
jimport( 'joomla.application.component.controller' );
jimport('joomla.application.component.model');
jimport('joomla.filesystem.folder');

$communityPath = JPATH_ROOT.'/components/com_community';

if(!JFolder::exists($communityPath))
	return;

// add include files
require_once JPATH_ROOT.'/administrator/components/com_jspc/includes.jspc.php';

if(JRequest::getCmd('view') == '') {
            JRequest::setVar('view', 'cpanel');
}

$controller	= $controller  = JRequest::getCmd( 'view');

if(!empty( $controller )){
	$controller	= JString::strtolower( $controller );
	$path		= JPATH_ADMINISTRATOR.'/components/com_jspc/controllers/'.$controller.'.php';

	// Test if the controller really exists
	if(file_exists($path))
		require_once( $path );
	else
		JError::raiseError( 500 , JspcText::_( 'INVALID_CONTROLLER_FILE_DOES_NOT_EXISTS_IN_THIS_CONTEXT' ) );
}

$class	= 'JspcController' . JString::ucfirst( $controller );

// Test if the object really exists in the current context
if( class_exists( $class ) )
	$controller	= new $class();
else
	JError::raiseError( 500 , 'Invalid Controller Object. Class definition does not exists in this context.' );

// Perform the Request task
$task = JRequest::getCmd('task');

/*if($task == '')
{
	JRequest::setVar('task', 'display');
	$task='display';
}
*/
// Task's are methods of the controller. Perform the Request task
$controller->execute( $task );
	
// Redirect if set by the controller
$controller->redirect();

