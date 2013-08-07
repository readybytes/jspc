<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class JspcModelAddons extends JModelLegacy
{
	
	 /* @var object	JPagination object
	 **/	 	 	 
	var $_pagination;
	/**
	 * Constructor
	 */
	function __construct()
	{
		$mainframe = JFactory::getApplication();

		// Call the parents constructor
		parent::__construct();

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( 'com_jspc.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	/**
	 * Retrieves the JPagination object
	 *
	 * @return object	JPagination object	 	 
	 **/	 	
	function getPagination()
	{
		if ($this->_pagination == null)
		{
			$this->getAddonsInfo();
		}
		return $this->_pagination;
	}
	
	/**
	 * Returns the Fields
	 *
	 * @return object	JParameter object
	 **/
	function getAddonsInfo()
	{
		$mainframe = JFactory::getApplication();

		static $addonsInfo;
		
		if( isset( $addonsInfo ) )
		{
			return $addonsInfo;
		}

		// Initialize variables
		$db			= JFactory::getDBO();

		// Get the limit / limitstart
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_jspclimitstart', 'limitstart', 0, 'int');

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart	= ($limit != 0) ? ($limitstart / $limit ) * $limit : 0;

		// Get the total number of records for pagination
		$query	= 'SELECT COUNT(*) FROM ' . $db->quoteName( '#__jspc_addons' );
		$db->setQuery( $query );
		$total	= $db->loadResult();

		jimport('joomla.html.pagination');
		
		// Get the pagination object
		$this->_pagination	= new JPagination( $total , $limitstart , $limit );

		$query	= 'SELECT * FROM ' 
				. $db->quoteName( '#__jspc_addons' );
		$db->setQuery( $query , $this->_pagination->limitstart , $this->_pagination->limit );		
		$addonsInfo	= $db->loadObjectList();
		
		return $addonsInfo;
	}
	
	function updatePublish($id,$value)
	{
		$db 	= JFactory::getDBO();
		$query 	= 'UPDATE #__jspc_addons'
				. ' SET `published` ='.$db->Quote($value).''
				. ' WHERE `id`='. $db->Quote($id);
		$db->setQuery( $query );
		if (!$db->query())
			return JError::raiseWarning( 500, $db->getError() );
			
		return true;
	}
	
	function getParamHtml($params, $set = null)
	{
		if(!isset($params)){
			return false;
		}
		
		$fields = $params->getFieldset($set);
		ob_start();?>
		<?php JHTML::_('behavior.tooltip'); ?>
		<div class="xipcParameter">
		
		<?php foreach ($fields as $field) : ?>
			<div class="xipcParameter xiRow" >
				<?php if ($field->fieldname && $field->fieldname != '&nbsp;'): ?>
					<div class="xipcParameter xiCol xiColKey">
						<?php echo $field->label; ?>
					</div>
					<div class="xipcParameter xiCol xiColValue">
						<?php echo $field->input; ?>
					</div>
				<?php else: ?>
					<div class="xipcParameter xiCol xiColDescription">
						<?php echo $field->description; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<?php if(count($fields) < 1) : ?>
			<div class="xipcParameter xiRow">
				<div class="xipcParameter xiCol"><i>
				<?php JText::_('There Are No Parameter For This plugin'); ?>
				</i></div>
			</div>
		<?php endif; ?>

		</div>

		<?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}