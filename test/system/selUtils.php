<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class XiSelTestCase extends PHPUnit_Extensions_SeleniumTestCase 
{
  var  $_DBO;
  protected $captureScreenshotOnFailure = TRUE;
  protected $screenshotPath = SCREENSHOT_PATH;
  protected $screenshotUrl  = SCREENSHOT_URL;
/*  
  protected $collectCodeCoverageInformation = TRUE;
  protected $coverageScriptUrl = 'http://localhost/phpunit_coverage.php';
 */ 
  function setUp()
  {
  	$this->parentSetup();
  }
  
  function parentSetup()
  {
  	$this->setHost(SEL_RC_SERVER);
  	$this->setPort(SEL_RC_PORT);
  	$this->setTimeout(10);
  	
  	//to be available to all childs
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION);
  }
  
  function assertPreConditions()
  {
    // this will be a assert for every test
    if(method_exists($this,'getSqlPath'))
        $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

  function assertPostConditions()
  {
     // if we need DB based setup then do this
     if(method_exists($this,'getSqlPath'))
         $this->assertTrue($this->_DBO->verify());
  }
  
  function adminLogin()
  {
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    $this->waitForPageToLoad("60000");

  	if(TEST_JSPC_JOOMLA_16)
    { 
	    $this->type("mod-login-username", JOOMLA_ADMIN_USERNAME);
	    $this->type("mod-login-password", JOOMLA_ADMIN_PASSWORD);
	    $this->click("//input[@value='Log in']");
    }
    elseif(TEST_JSPC_JOOMLA_15)
    {
    	$this->type("modlgn_username", JOOMLA_ADMIN_USERNAME);
    	$this->type("modlgn_passwd", JOOMLA_ADMIN_PASSWORD);
    	$this->click("//form[@id='form-login']/div[1]/div/div/a");
    }

    $this->waitForPageToLoad();
  }
  
  function frontLogin($username=JOOMLA_ADMIN_USERNAME, $password= JOOMLA_ADMIN_PASSWORD)
  {
    $this->open(JOOMLA_LOCATION."/index.php");
    $this->waitForPageToLoad("60000");

    if (TEST_JSPC_JOOMLA_15){
    	$this->type("modlgn_username", $username);
    	$this->type("modlgn_passwd", $password);
    	$this->click("//form[@id='form-login']/fieldset/input");
    }
    if (TEST_JSPC_JOOMLA_16){
    	$this->type("modlgn-username", $username);
    	$this->type("modlgn-passwd", $password);
    	$this->click("Submit");
    }
  	$this->waitPageLoad();
    if (TEST_JSPC_JOOMLA_15)
    	$this->assertEquals("Log out", $this->getValue("//form[@id='form-login']/div[2]/input"));
    if (TEST_JSPC_JOOMLA_16)
    	$this->assertEquals("Log out", $this->getValue("//form[@id='login-form']/div[2]/input[1]"));
  }
  
  function frontLogout()
  {
  	$this->open(JOOMLA_LOCATION."/index.php");
    $this->waitForPageToLoad("30000");
    
    if (TEST_JSPC_JOOMLA_15){
       	$this->assertEquals("Log out", $this->getValue("//form[@id='form-login']/div[2]/input"));
       	$this->click("//form[@id='form-login']/div[2]/input");
    }
    if (TEST_JSPC_JOOMLA_16){
    	$this->assertEquals("Log out", $this->getValue("//form[@id='login-form']/div[2]/input"));
    	 $this->click("//form[@id='login-form']/div[2]/input");
    }
    $this->waitForPageToLoad("60000");
    if (TEST_JSPC_JOOMLA_15)
    	$this->assertTrue($this->isElementPresent("modlgn_username"));
    if (TEST_JSPC_JOOMLA_16)
    	$this->assertTrue($this->isElementPresent("modlgn-username"));
  }
  
  function waitPageLoad($time=TIMEOUT_SEC)
  {
      $this->waitForPageToLoad($time);
      // now we just want to verify that 
      // page does not have any type of error
      // JSPC SYSTEM ERROR
      $this->assertFalse($this->isTextPresent("( ! ) Notice:"));
      // a call stack ping due to assert/notice etc.
  }
  
  function waitForElement($element)
  {
	  //wait for ajax window
  		for ($second = 0; ; $second++) {
	        if ($second >= 10) $this->fail("timeout");
	        try {
	            if ($this->isElementPresent($element)) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
  }
  
  function changeJomSocialConfig($filters)
  {
	require_once (JPATH_BASE . '/components/com_community/libraries/core.php' );
	$query = "SELECT params FROM `#__community_config` WHERE `name`='config'";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$params=$db->loadResult();
	
	$newParams = new JParameter($params);
	foreach($filters as $key => $value)
		$newParams->set($key,$value);
		
	$paraStr = '';
	$allData = $newParams->_registry['_default']['data']; 
	foreach ($allData as $key => $value)
		$paraStr .= "$key=$value\n";
		
	$query = "UPDATE `#__community_config` SET `params`='".$paraStr."' WHERE `name`='config'";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$db->query();
  }
  
  function changeJSPTConfig($filters)
  {
 
  	if(!$filters)
  		return;
  		
	$query = "SELECT params FROM `#__components` WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1 ";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$params=$db->loadResult();
	
	$newParams = new JParameter($params);
	
	foreach($filters as $key => $value)
		$newParams->set($key,$value);
		
	$paraStr = '';
	$allData = $newParams->_registry['_default']['data']; 
	foreach ($allData as $key => $value)
		$paraStr .= "$key=$value\n";
		
	$query = "UPDATE `#__components` SET `params`='".$paraStr."' WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$db->query();
  	
	$done=true;
  }

  
  function changePluginState($pluginname, $action=1)
  {
  	
		$db			=& JFactory::getDBO();
		
  		if(TEST_JSPC_JOOMLA_16){
			$query	= 'UPDATE ' . $db->nameQuote( '#__extensions' )
			. ' SET '.$db->nameQuote('enabled').'='.$db->Quote($action)
	        .' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
		}
		else{
				$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);			
		}

		$db->setQuery($query);		
		
		if(!$db->query())
			return false;
			
		return true;
  }
  
  
  /**
   * Verifies that plugin is in correct state
   * @param $pluginname : Name of plugin
   * @param $enabled : Boolean, 
   * @return unknown_type
   */
  function verifyPluginState($pluginname, $enabled=true)
  {
  		
		$db			=& JFactory::getDBO();
  		if(TEST_JSPC_JOOMLA_16){
		   $query	= 'SELECT '.$db->nameQuote('enabled')
		   .' FROM ' . $db->nameQuote( '#__extensions' )
	       .' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
		}
		if(TEST_JSPC_JOOMLA_15){
		   $query	= 'SELECT '.$db->nameQuote('published')
		   .' FROM ' . $db->nameQuote( '#__plugins' )
	       .' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
		}

		$db->setQuery($query);		
		$actualState= (boolean) $db->loadResult();
		$this->assertEquals($actualState, $enabled);
  }
  
  
  
  function changeModuleState($modulename, $action=1)
  {
  	
		$db			=& JFactory::getDBO();
		
  		if(TEST_JSPC_JOOMLA_16){
			$query	= 'UPDATE ' . $db->nameQuote( '#__extensions' )
			. ' SET '.$db->nameQuote('enabled').'='.$db->Quote($action)
	        .' WHERE '.$db->nameQuote('element').'='.$db->Quote($modulename);
		}
		else{
		$query	= 'UPDATE ' . $db->nameQuote( '#__modules' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          	.' WHERE '.$db->nameQuote('module').'='.$db->Quote($modulename);
		}
	          	
		$db->setQuery($query);		
		
		if(!$db->query())
			return false;
			
		return true;
  }
  
  function verifyModuleState($modulename, $enabled=true)
  {
  	
		$db			=& JFactory::getDBO();
		
		if(TEST_JSPC_JOOMLA_16){
		   $query	= 'SELECT '.$db->nameQuote('enabled')
		   .' FROM ' . $db->nameQuote( '#__extensions' )
	       .' WHERE '.$db->nameQuote('element').'='.$db->Quote($modulename);
		}
		if(TEST_JSPC_JOOMLA_15){
		$query	= 'SELECT '.$db->nameQuote('published')
				.' FROM ' . $db->nameQuote( '#__modules' )
	          	.' WHERE '.$db->nameQuote('module').'='.$db->Quote($modulename);
		}
		$db->setQuery($query);		
		$actualState= (boolean) $db->loadResult();
		$this->assertEquals($actualState, $enabled);
  }
  
  
}
