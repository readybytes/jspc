<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

class JspcControllerAddons extends JControllerLegacy 
{
   
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display($cachable = false, $urlparams = array()) 
    {
		parent::display();
    }
    
    function add()
	{
		$viewName	= JRequest::getCmd( 'view' , 'addons' );
		
		// Get the document object
		$document	= JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		$view		= $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'addon.add' );
			
		$view->setLayout( $layout );

		echo $view->add();
	}
	
	function renderaddon()
	{
		$id    = JRequest::getVar('editId', 0 );
		$addon = JRequest::getVar('addon', 0 ) ;
		
		$viewName	= JRequest::getCmd( 'view' , 'addons' );
		
		// Get the document object
		$document	= JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		$view		= $this->getView( $viewName , $viewType );
		
		if(!$addon && !$id) {
			$layout		= JRequest::getCmd( 'layout' , 'addon.add' );
			$view->setLayout( $layout );
			echo $view->add();
			return;
		}
		
		$data = array();
		$data['id'] = $id;
		
		if($addon) {
			$data['name'] 			= $addon;
			$data['featurename'] 	= '';
			$data['published'] 		= 1;
			$data['coreparams'] 	= '';
			$data['addonparams'] 	= '';
		}
		
		if($id){
			
			$filter		  	= array();
			$filter['id'] 	= $id;
			$info 			= addonFactory::getAddonsInfo($filter);
			
			if(!$info) {
				$layout		= JRequest::getCmd( 'layout' , 'addon.add' );
				$view->setLayout( $layout );
				echo $view->add();
				return;
			}
					
			$data['name'] 			= $info[0]->name;
			$data['featurename'] 	= $info[0]->featurename;
			$data['published'] 		= $info[0]->published;
			$data['coreparams'] 	= (array)json_decode($info[0]->coreparams);
			$data['addonparams'] 	= (array)json_decode($info[0]->addonparams);
		}
		
		$layout		= JRequest::getCmd( 'layout' , 'param.edit' );
		$view->setLayout( $layout );
		echo $view->renderaddon($data);
	}
	
	function processSave()
	{
		//save addonparam and core param in individual columns
		// Test if this is really a post request
		$method	= JRequest::getMethod();
		$id 	= JRequest::getVar('editId', 0 );
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , JspcText::_('CC_ACCESS_METHOD_NOT_ALLOWED') );
			return;
		}
		
		$mainframe	= JFactory::getApplication();
		$post		= JRequest::get('post');
		
		jimport('joomla.filesystem.file');

		$addons	= JTable::getInstance( 'addons' , 'JspcTable' );
		$addons->load($post['id']);
				
		$data = array();
		
		$data['coreparams']		= json_encode($post['coreparams']);
		$data['addonparams']	= isset($post['addonparams']) ? json_encode($post['addonparams']) : '';
		$data['id'] 			= $post['id'];
		$data['name'] 			= $post['name'];
		$data['featurename'] 	= $post['featurename'];
		$data['published'] 		= $post['published'];
		
		unset($post['id']);
		unset($post['name']);
		unset($post['featurename']);
		unset($post['published']);
		unset($post['coreparams']);
		unset($post['addonparams']);
//		
//		$addonObject 			= addonFactory::getAddonObject($data['name']);
//		$data['addonparams'] 	= $addonObject->collectParamsFromPost($post);
//		
		
		$addons->bind($data);
		$msg = '';
		// Save it
		if(! ($id = $addons->store()) )
			$msg = JspcText::_('ERROR_IN_SAVING_CRITERIA');
		else
			$msg = JspcText::_('CRITERIA_SAVED');	

		$result = array($msg, $id);
		return $result;
	}
	
	function save()
	{
		$result		= $this->processSave();
		$link 		= JRoute::_('index.php?option=com_jspc&view=addons', false);
		$mainframe	= JFactory::getApplication();
		$mainframe->enqueueMessage($result[0]);
		$mainframe->redirect($link);		
		
	}
	
	function apply()
	{
		$result 	= $this->processSave();
		$link 		= JRoute::_('index.php?option=com_jspc&view=addons&task=renderaddon&editId='.$result[1], false);
		$mainframe	= JFactory::getApplication();
		$mainframe->enqueueMessage($result[0]);
		$mainframe->redirect($link);				
	}
	
	function remove()
	{
		$mainframe = JFactory::getApplication();
		// Check for request forgeries
		
		$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		//$post['id'] = (int) $cid[0];
		$count	= count($ids);
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');
		$row	= JTable::getInstance( 'addons' , 'JspcTable' );
		$i = 1;
		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$message	= JspcText::_('ERROR_IN_REMOVING_CRITERIA');
					$mainframe->enqueueMessage($message);
					$mainframe->redirect( 'index.php?option=com_jspc&view=addons');
					exit;
				}
				$i++;
			}
		}
				
		$cache = JFactory::getCache('com_content');
		$cache->clean();
		
		$message	= $count.' '.JspcText::_('CRITERIA_REMOVED');		
		$link 		= JRoute::_('index.php?option=com_jspc&view=addons', false);
		$mainframe->enqueueMessage($message);
		$mainframe->redirect($link);
	}
	
	function publish()
	{
		$mainframe = JFactory::getApplication();
		// Check for request forgeries
		// Initialize variables
		$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count	= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, JspcText::_( 'NO_ITEMS_SELECTED' ) );
		}
		
		$aModel	= JspcFactory::getModel( 'addons' );
		foreach($ids as $id)
		{
			$aModel->updatePublish($id,1);
		}
		$msg  = JspcText::sprintf( $count.' ITEMS_PUBLISHED' );
		$link = JRoute::_('index.php?option=com_jspc&view=addons', false);
		$mainframe->enqueueMessage($msg);
		$mainframe->redirect($link);
		return true;
	}
	
	function unpublish()
	{
		$mainframe = JFactory::getApplication();
		// Check for request forgeries
		// Initialize variables
		$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count	= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, JspcText::_( 'NO_ITEMS_SELECTED' ) );
		}
		
		$aModel	= JspcFactory::getModel( 'addons' );
		foreach($ids as $id)
		{
			$aModel->updatePublish($id,0);
		}
		$msg  = JspcText::sprintf( $count.' ITEMS_UNPUBLISHED' );
		$link = JRoute::_('index.php?option=com_jspc&view=addons', false);
		$mainframe->enqueueMessage($msg);
		$mainframe->redirect($link);
		return true;
	}
	
	function aboutus()
	{
		$viewName	= JRequest::getCmd( 'view' , 'addons' );
				// Get the document object
		$document	= JFactory::getDocument();
		// Get the view type
		$viewType	= $document->getType();
		$view		= $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'aboutus' );
		$view->setLayout( $layout );
		//echo parent::display();
		echo $view->aboutus();
	}
}
