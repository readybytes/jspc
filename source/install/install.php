<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
define('JSPC_VERSION','@global.version@.@svn.lastrevision@');

class Com_jspcInstallerScript
{
	function install($parent)
	{
		if($this->check_jomsocial_existance() == false)
			return false;
			
		if($this->setup_database() == false)
			JError::raiseError('INSTERR', "Not able to setup JSPC database correctly");	
		
		//check if migration is required
		if(!$this->isTableExist('jspc_config') && $this->isTableExist('jspc_addons'))
		{
			$this->doMigration();
			$this->jspcConfig();
		}
	
		if($this->installExtensions() == false){
			JError::raiseError('INSTERR', "NOT ABLE TO INSTALL EXTENSIONS");
			return false;
		}	
	}
	
	function setup_database()
	{		
		if($this->isTableExist('jspc_addons'))
		{
			return true;
		}
	
		return false;
	}
	
	function uninstall($parent)
	{
		$state=0;
		$extensions[] 	= array('type'=>'community',   'name'=>'jspc');
		$this->changeExtensionState($extensions, $state);

		return true;
	}

	
	function update($parent)
	{
		self::install($parent);
	}
	
	function changeExtensionState($extensions = array(), $state = 1)
	{
		if(empty($extensions)){
			return true;
		}

		$db		= JFactory::getDBO();
		$query		= 'UPDATE '. $db->quoteName( '#__extensions' )
				. ' SET   '. $db->quoteName('enabled').'='.$db->Quote($state);

		$subQuery = array();
		foreach($extensions as $extension => $value){
			$subQuery[] = '('.$db->quoteName('element').'='.$db->Quote($value['name'])
				    . ' AND ' . $db->quoteName('folder').'='.$db->Quote($value['type'])
			            .'  AND `type`="plugin"  )   ';
		}

		$query .= 'WHERE '.implode(' OR ', $subQuery);

		$db->setQuery($query);
		return $db->query();
	}
	
	
	function check_jomsocial_existance()
	{
		$jomsocial_admin = JPATH_ROOT .'/administrator/components/com_community';
		$jomsocial_front = JPATH_ROOT .'/components/com_community';
		
		if(!is_dir($jomsocial_admin))
			return false;
		
		if(!is_dir($jomsocial_front))
			return false;
		
		return true;
	}
	
	function isTableExist($tableName)
	{
		$mainframe	= JFactory::getApplication();
	
		$tables	= array();
	
		$database = JFactory::getDBO();
		$tables	  = $database->getTableList();
	
		return in_array( $mainframe->getCfg( 'dbprefix' ) . $tableName, $tables );
	}
	
	function installExtensions($extPath=null)
	{
		//if no path defined, use default path
		if($extPath==null)
			$extPath = JPATH_ROOT.'/administrator/components/com_jspc/install/extensions';
	
		if(!JFolder::exists($extPath))
			return false;
	
		$extensions	= JFolder::folders($extPath);
	
		//no apps there to install
		if(empty($extensions))
			return true;
	
		//get instance of installer
		$installer =  new JInstaller();
		$installer->setOverwrite(true);
	
		//install all apps
		foreach ($extensions as $ext)
		{
			$msg = "Supportive Plugin/Module $ext Installed Successfully";
	
			// Install the packages
			if($installer->install($extPath.'/'.$ext)==false)
				$msg = "Supportive Plugin/Module $ext Installation Failed";
	
			//enque the message
			JFactory::getApplication()->enqueueMessage($msg);
		}
	
		return true;
	}
	
	function insertSampleData()
	{       
	        $query          = " SELECT count(`id`) FROM `#__jspc_addons` ";
	        
	        $db		= JFactory::getDBO();
	        $db->setQuery( $query );
	        $result		=$db->query();
	        if($result)
	                return;
	                
	        $insertQuery = "INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`)"
	                                        ." VALUES (1, 'albums', 'Create 8 Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Create %s Album\njspc_profiletype=0\n\n', 'albums_total=8\n\n', 1),"
	                                        ." (2, 'groupowner', 'Create 5 Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Create %s Group\njspc_profiletype=0\n\n', 'groupowner_total=5\n\n', 1),"
	                                        ." (3, 'photos', 'Add 9 Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Add %s Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 1),"
	                                        ." (4, 'avatar', 'Upload Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload Avtar\njspc_profiletype=0\n\n', '\n', 1),"
	                                        ." (5, 'groupmember', 'Join 6 Group', 'jspc_core_total_contribution=70\njspc_core_display_text=Join %s Group\njspc_profiletype=0\n\n', 'groupmember_total=6\n\n', 1),"
	                                        ." (6, 'videos', 'Upload 4 Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload %s Videos\njspc_profiletype=0\n\n', 'videos_total=4\n\n', 1),"
	                                        ." (7, 'profilefields', 'Edit Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Edit Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 1)";
	        
	        $db= JFactory::getDBO();
	        $db->setQuery( $insertQuery );
	        $db->query();
	        
	        return;
	
	}
	
	function doMigration()
	{
		$this->migrateJspcParam();
		return true;
	}
	
	function migrateJspcParam()
	{
		$db		= JFactory::getDBO();
		$sql    = " SELECT * FROM `#__jspc_addons` ";
		$db->setQuery($sql);
		
		$addonsinfo = $db->loadObjectList('id');
		
		foreach ($addonsinfo as $addon)
		{
			$coreParams 	= $this->convertToJSON($addon->coreparams, 'coreparams');
			$addonParams 	= $this->convertToJSON($addon->addonparams, 'addonparams');
				
			$update_query = " UPDATE `#__jspc_addons` "
							. " SET " .$db->quoteName('coreparams').' = '.$db->quote($coreParams) .' , '
							. $db->quoteName('addonparams').' = '.$db->quote($addonParams)
							. " WHERE " .$db->quoteName('id').' = '.$db->quote($addon->id);
						
			$db->setQuery($update_query)->query();
		}
					    
	}
	
	//convert all INI field values into JSON
	function convertToJSON($data = '', $what = '')
	{
		if($data == ''){
			return '';
		}
		
		$registry =new JRegistry(addslashes($data));
		return json_encode($registry->toObject());
	}
	
	// create Jspc config table for managing previous version
	function jspcConfig()
	{
		$sql 	= 'CREATE TABLE IF NOT EXISTS `#__jspc_config` (
							  `name`    	   VARCHAR(255) NOT NULL ,
	  						  `params`         TEXT NOT NULL
							)';
		
		$db = JFactory::getDBO();
		$db->setQuery( $sql );
		
		if($db->query())
		{	
			$sqlquery = "INSERT INTO `#__jspc_config`(`name`,`params`)
			              	            VALUES ('version','".JSPC_VERSION."')";
			$db->setQuery($sqlquery);
			$db->query();
		}
	}
	
	function postflight($type, $parent)
	{
		return $this->_addScript();
	}

	function _addScript()
	{
		
		?>
			<script type="text/javascript">
				window.onload = function(){	
				  setTimeout("location.href = 'index.php?option=com_jspc&view=install';", 100);
				}
			</script>
		<?php
	}	
}
