<?php
class UninstallJspcTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testuninstallJspc()
  {
  	 // setup default location 
    $this->adminLogin();

    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

     $this->click("//a[@onclick=\"javascript:document.adminForm.type.value='components';submitbutton('manage');\"]");
     $this->waitPageLoad();
     
     //now find the component order in uninstall list
     $order = $this->getUninstallOrder('com_jspc');
     $this->click("cb$order");
     $this->click("link=Uninstall");
     $this->waitPageLoad();
     $this->assertTrue($this->isTextPresent("Uninstall Component Success"));
     $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
   
     
     $this->changePluginState("jspc",0);
  	 $this->verifyPluginState("jspc",false);  	 

	 $this->changeModuleState("mod_jspc",0);
  	 $this->verifyModuleState("mod_jspc",false);
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