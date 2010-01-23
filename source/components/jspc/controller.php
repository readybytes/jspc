<?php
/**
 * profilestatus Controller
 *
 * @package Joomla
 * @subpackage profilestatus
 */
class ProfilestatusController extends JController {
    /**
     * Constructor
     * @access private
     * @subpackage profilestatus
     */
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() {
        if(JRequest::getCmd('view') == '') {
            JRequest::setVar('view', 'othervalue');
        }
		
		//require_once (JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_profilestatus' . DS .'helpers'.DS.'profilestatus.php');
		
		parent::display();
    }
	
	function editField()
	{
		$fieldId = JRequest::getVar('editId', 0 , 'GET');
		$rowid = ProfilestatusHelper::get_id_from_fieldId_from_fieldsvalue($fieldId);
		$row = ProfilestatusHelper::getfieldvalue($rowid);
		$viewName	= JRequest::getCmd( 'view' , 'profilestatus' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		// Get the view
		$data = array();
		$data['rowid'] = $rowid;
		$data['fieldname'] = ProfilestatusHelper::get_fieldname_from_fieldid($fieldId);
		$data['fieldid'] = $fieldId;
		if(!empty($row))
			$data['value'] = $row->value;
		else
			$data['value'] = 0;
		
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'fieldsvalue.edit' );
		$view->setLayout( $layout );
		echo $view->editField($data);
		
	}
	
	function saveField()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];
		
		$model = $this->getModel('profilestatus');
		$data = array();
		$data['id'] = $post['id'];
		$data['fieldid'] = $post['fieldid'];//JRequest::getVar( 'fieldid', 0,'post' );
		$data['value'] = $post['percentage'];
		
		$psModel =& $this->getModel('profilestatus');
		
		if(!$psModel->store($data))
		{
				$msg = JText::_( 'Error Saving fields value' );
		}
		else
		{
			$msg = JText::_( 'Field Saved' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		//$model->checkin();
		
		$link = JRoute::_('index.php?option=com_profilestatus&view=fieldsvalue', false);
		$mainframe->redirect($link, $msg);
	}
	
	function editOther()
	{
		$ovModel =& $this->getModel('othervalue');
		$id = JRequest::getVar('editId', 0 , 'GET');
		$field = $ovModel->getDataFromId($id);
		
		$viewName	= JRequest::getCmd( 'view' , 'profilestatus' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		// Get the view
		
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'othervalue.edit' );
		$view->setLayout( $layout );
		//print_r($field);
		echo $view->editOther($field);
		
	}
	
	function saveOther()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');
		//$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		//$post['id'] = (int) $cid[0];
		
		$ovModel = $this->getModel('othervalue');
		$data = array();
		$data['id'] = $post['id'];
		$data['name'] = $post['name'];//JRequest::getVar( 'fieldid', 0,'post' );
		$data['total'] = $post['total'];
		$data['value'] = $post['value'];
		
		if(!$ovModel->store($data))
		{
				$msg = JText::_( 'Error Saving value' );
		}
		else
		{
			$msg = JText::_( 'Value Saved' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		//$model->checkin();
		
		$link = JRoute::_('index.php?option=com_profilestatus&view=othervalue', false);
		$mainframe->redirect($link, $msg);
	}
	
	function cancelField()
	{
		// Check for request forgeries
		global $mainframe;
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe->redirect( 'index.php?option=com_profilestatus' );

	}
	
	function cancelOther()
	{
		// Check for request forgeries
		global $mainframe;
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe->redirect( 'index.php?option=com_profilestatus&view=othervalue' );

	}
}