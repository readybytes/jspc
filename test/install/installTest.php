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
  function testCommunityInstall()
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
    $this->installJspcPlugin();
    $this->installJspcModule();
    $this->changePluginState('jspc',1);
    $this->verifyPluginState('jspc',true);
    $this->changeModuleState('mod_jspc',1);
    $this->verifyModuleState('mod_jspc',true);
  }

   /**
   */
  function installJspcComponent()
  {
    $this->type("install_package", COM_JSPC_PKG);
    $this->click("//form[@name='adminForm']/table[1]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
  }
  
  
  
  /**
   */
  function installJspcPlugin()
  {
    $this->type("install_package", PLG_JSPC_PKG);
    $this->click("//form[@name='adminForm']/table[1]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
  }
  
  /**
   */
  function installJspcModule()
  {
    $this->type("install_package", MOD_JSPC_PKG);
    $this->click("//form[@name='adminForm']/table[1]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Module Success"));
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
  
  function testReinstallJspc()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
    $this->installJspcComponent();
    //$this->installJspcPlugin();
    //$this->installJspcModule();
    $this->changePluginState('jspc',1);
    $this->verifyPluginState('jspc',true);
    $this->changeModuleState('mod_jspc',1);
    $this->verifyModuleState('mod_jspc',true);
  }
  
  
  
} 

