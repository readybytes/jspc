<?php

class InstallTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    
    //verify tables setup
    $this->assertEquals($this->_DBO->getErrorLog(),'');
  }


  /**
   * We will upgrade JomSocial from existing 1.5.248 + JSPT installation
   * @return unknown_type
   */
  function xtestCommunityInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
      
    // add profiletype-one
    $this->type("install_package", JOMSOCIAL_PKG);
    $this->click("//form[@name='adminForm']/table[1]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();

    $this->click("//div[@id='element-box']/div[2]/table/tbody/tr[2]/td/table/tbody/tr[2]/td/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");

    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->click("//form[@id='installform']/div/div/input");
    $this->waitForPageToLoad("30000");
    $this->assertTrue($this->isTextPresent("Jom Social"));
  }



  function testInstallJspc()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
    $this->installJspcComponent();
    $this->changePluginState('jspc',1);
    $this->verifyPluginState('jspc',true);
    $this->changeModuleState('mod_jspc',1);
    $this->verifyModuleState('mod_jspc',true);
  }

   /**
   */
  function installJspcComponent()
  {
    $this->type("install_url", COM_JSPC_PKG);
    
    if(TEST_JSPC_JOOMLA_16){ 
   		$this->click("//input[@value='Install' and @type='button' and @onclick='Joomla.submitbutton4()']");
   	}
   	if(TEST_JSPC_JOOMLA_15){
   	  	$this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
   	}
   	
	    
    $this->waitPageLoad();
    if(TEST_JSPC_JOOMLA_16)
    	$this->assertTrue($this->isTextPresent("Installing component was successful."));
    if(TEST_JSPC_JOOMLA_15)
    	$this->assertTrue($this->isTextPresent("Install Component Success"));
    
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
  }
  
function testuninstallJspc()
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
      	$this->type("filters_search", "jspc");
    	$this->click("//button[@type='submit']");
    	$this->waitPageLoad();
    	$this->click("cb0");
    	$this->click("//li[@id='toolbar-delete']/a/span");	
     }
     if(TEST_JSPC_JOOMLA_15){
     	$order = $this->getUninstallOrder('com_jspc');
     	$this->click("cb$order");
     	$this->click("link=Uninstall");
     }
     $this->waitPageLoad();
     
     if(TEST_JSPC_JOOMLA_16)
     	$this->assertTrue($this->isTextPresent("Uninstalling component was successful."));
     if(TEST_JSPC_JOOMLA_15)
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
  	if(TEST_JSPC_JOOMLA_16){
  		$sql = "SELECT * FROM `#__extensions`
  		WHERE `client_id` = '0'
  		ORDER BY `name`";
  	}
  	elseif(TEST_JSPC_JOOMLA_15){
  		$sql = "SELECT * FROM `#__components`
  		WHERE `parent` = '0'
  		ORDER BY `iscore`, `name`";
  	}
  	
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
  
  function testReinstallJspc()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
    $this->installJspcComponent();
    $this->changePluginState('jspc',1);
    $this->verifyPluginState('jspc',true);
    $this->changeModuleState('mod_jspc',1);
    $this->verifyModuleState('mod_jspc',true);
  }
  
  
  
} 

