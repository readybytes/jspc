<?php

class UninstallXiptTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testuninstallJspt()
  {
  	 // setup default location 
    $this->adminLogin();

    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

    if(TEST_JSPC_JOOMLA_16)
     	$this->click("link=Manage");
    if(TEST_JSPC_JOOMLA_15)
     	$this->click("//a[@onclick=\"javascript:document.adminForm.type.value='components';submitbutton('manage');\"]");
     
     $this->waitPageLoad();
     
     //now find the component order in uninstall list
     if(TEST_JSPC_JOOMLA_16){
      	$this->type("filters_search", "xipt");
    	$this->click("//button[@type='submit']");
    	$this->waitPageLoad();
    	$this->click("cb0");
    	$this->click("//li[@id='toolbar-delete']/a/span");	
     }
     if(TEST_JSPC_JOOMLA_15){
     $order = $this->getUninstallOrder('com_xipt');
     $this->click("cb$order");
     $this->click("link=Uninstall");
     }
     
     $this->waitPageLoad();
     
     if(TEST_JSPC_JOOMLA_16)
     	$this->assertTrue($this->isTextPresent("Uninstalling component was successful."));
     if(TEST_JSPC_JOOMLA_15)
     	$this->assertTrue($this->isTextPresent("Uninstall Component Success"));
     	
     $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
     $this->verifyUninstall();
     
     $this->changePluginState("xipt_system",0);
  	 $this->verifyPluginState("xipt_system",false);
  	 $this->changePluginState("xipt_community",0);
  	 $this->verifyPluginState("xipt_community",false);
  }
  function verifyUninstall()
  {
  		jimport( 'joomla.filesystem.file' );
    	jimport( 'joomla.filesystem.folder' );
  		//1. Plugins are disabled
  		//2. Files are properly unpatched
  		//3. Custom Fields have been unpublished
  		//4. AEC MI should not apply any action

  		//1.
  		$this->verifyPluginState('plg_xipt_community',false);
  		$this->verifyPluginState('plg_xipt_system',false);

  		//2.
  		$CMP_PATH_FRNTEND = JPATH_ROOT .DS. 'components' . DS . 'com_community';
  		$CMP_PATH_ADMIN	  = JPATH_ROOT .DS. 'administrator' .DS.'components' . DS . 'com_community';
  		$hackedFiles[]=$CMP_PATH_FRNTEND.DS.'libraries' .DS.'fields'.DS.'customfields.xml';
  		$hackedFiles[]=$CMP_PATH_FRNTEND.DS.'models'	.DS.'profile.php';
  		$hackedFiles[]=$CMP_PATH_ADMIN  .DS.'models'	.DS.'users.php';
  		foreach($hackedFiles as $file)
  			$this->assertFalse(JFile::exists($file.".jxibak"));
  		
  		//3.
  		$db		= JFactory::getDBO();		
  		$query	= " SELECT *  FROM `#__community_fields` " 
	          	. " WHERE `published` = '1' "
	          	. " AND (`type` = 'profiletypes' OR `type` = 'templates') ";
	    $db->setQuery($query);
	    $result = $db->loadResult();
	    $this->assertTrue($result === null);
  }
  
  function getUninstallOrder($component, $what = "COMPONENT")
  {
  	$db = JFactory::getDBO();
  	$sql = "SELECT * FROM `#__components`
  			WHERE `parent` = '0'
  			ORDER BY `iscore`, `name`";
  	$db->setQuery($sql);
    $results = $db->loadAssocList();
    
    $i=0;
    foreach($results as $r)
    {
    	if($r['option']==$component)
    		return $i;
    	
    	$i++;
    }
    
    return -1;
  }
}