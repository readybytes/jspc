<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

class JspcControllerAddons extends JController 
{
   
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
    {
		parent::display();
    }
    

    function add()
	{
		$viewName	= JRequest::getCmd( 'view' , 'addons' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		$layout		= JRequest::getCmd( 'layout' , 'addon.add' );
			
		$view->setLayout( $layout );

		echo $view->add();
	}
	
	
	function renderaddon()
	{
		$id = JRequest::getVar('editId', 0 );
		$addon = JRequest::getVar('addon', 0 ) ;
		
		$viewName	= JRequest::getCmd( 'view' , 'addons' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		if(!$addon && !$id) {
			$layout		= JRequest::getCmd( 'layout' , 'addon.add' );
			$view->setLayout( $layout );
			echo $view->add();
			return;
		}
		
		$data = array();
		$data['id'] = $id;
		
		if($addon) {
			$data['name'] = $addon;
			$data['featurename'] = '';
			$data['published'] = 1;
			$data['coreparams'] = '';
			$data['addonparams'] = '';
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
			$data['coreparams'] 	= $info[0]->coreparams;
			$data['addonparams'] 	= $info[0]->addonparams;
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
		$id = JRequest::getVar('editId', 0 );
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , JText::_('CC ACCESS METHOD NOT ALLOWED') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();

		$post	= JRequest::get('post');
		
		jimport('joomla.filesystem.file');

		$addons	=& JTable::getInstance( 'addons' , 'JspcTable' );
		$addons->load($post['id']);
				
		$data = array();
		
		$registry	=& JRegistry::getInstance( 'jspc' );
		$registry->loadArray($post['coreparams'],'jspc_coreparams');
		// Get the complete INI string
		$data['coreparams']	= $registry->toString('INI' , 'jspc_coreparams' );
		
		$data['id'] 			= $post['id'];
		$data['name'] 			= $post['name'];
		$data['featurename'] 	= $post['featurename'];
		$data['published'] 		= $post['published'];
		
		unset($post['id']);
		unset($post['name']);
		unset($post['featurename']);
		unset($post['published']);
		unset($post['coreparams']);
		
		$addonObject = addonFactory::getAddonObject($data['name']);
		$data['addonparams'] = $addonObject->collectParamsFromPost($post);
		
		
		$addons->bind($data);
		$msg = '';
		// Save it
		if(! ($id = $addons->store()) )
			$msg = JText::_('ERROR IN SAVING CRITERIA');
		else
			$msg = JText::_('CRITERIA SAVED');	

		return $id;
	}
	
	function save()
	{
		$this->processSave();
		$link = JRoute::_('index.php?option=com_jspc&view=addons', false);
		$mainframe	=& JFactory::getApplication();
		$mainframe->redirect($link, $msg);		
		
	}
	
	function apply()
	{
		$id = $this->processSave();
		$link = JRoute::_('index.php?option=com_jspc&view=addons&task=renderaddon&editId='.$id, false);
		$mainframe	=& JFactory::getApplication();
		$mainframe->redirect($link, $msg);				
	}
	
	function remove()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		//$post['id'] = (int) $cid[0];
		$count	= count($ids);
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'addons' , 'JspcTable' );
		$i = 1;
		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$message	= JText::_('ERROR IN REMOVING CRITERIA');
					$mainframe->redirect( 'index.php?option=com_jspc&view=addons' , $message);
					exit;
				}
				$i++;
			}
		}
				
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$message	= $count.' '.JText::_('CRITERIA REMOVED');		
		$link = JRoute::_('index.php?option=com_jspc&view=addons', false);
		$mainframe->redirect($link, $message);
	}
	
	
	function publish()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$aModel	= JspcFactory::getModel( 'addons' );
		foreach($ids as $id)
		{
			$aModel->updatePublish($id,1);
		}
		$msg = JText::sprintf( $count.' ITEMS PUBLISHED' );
		$link = JRoute::_('index.php?option=com_jspc&view=addons', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
	
	function unpublish()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$aModel	= JspcFactory::getModel( 'addons' );
		foreach($ids as $id)
		{
			$aModel->updatePublish($id,0);
		}
		$msg = JText::sprintf( $count.' ITEMS UNPUBLISHED' );
		$link = JRoute::_('index.php?option=com_jspc&view=addons', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
	
	
	function aboutus()
	{
		$viewName	= JRequest::getCmd( 'view' , 'addons' );
				// Get the document object
		$document	=& JFactory::getDocument();
		// Get the view type
		$viewType	= $document->getType();
	
		$view		=& $this->getView( $viewName , $viewType );

		$layout		= JRequest::getCmd( 'layout' , 'aboutus' );
		$view->setLayout( $layout );
		//echo parent::display();
		echo $view->aboutus();
	}

	
}
