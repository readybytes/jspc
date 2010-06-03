<?php
class CompletenessTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testModule_Plug_Working()
  {
  	// enable module
  	$this->changeModuleState("mod_jspc",1);
  	$this->verifyModuleState("mod_jspc",true); 	
  	
  	$this->frontLogin("gaurav","gaurav");
  	$this->open(JOOMLA_LOCATION."index.php");
  	$this->waitPageLoad();
  	$element = '//img[@src="/'.JOOMLA_FOLDER.'/media/system/images/jspc/mod_56.5.jpg"]'; 
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$this->assertTrue($this->isTextPresent("Add 6 Album"));
  	$this->assertTrue($this->isTextPresent("Add 4 Album2"));
  	$this->assertTrue($this->isTextPresent("Create 3 Group"));
  	$this->assertTrue($this->isTextPresent("Join 3 Group"));
  	
  	$element = '//a[@id="jspc_incomplete_link_1"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$element = '//a[@id="jspc_incomplete_link_8"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$element = '//a[@id="jspc_incomplete_link_2"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$element = '//a[@id="jspc_incomplete_link_5"]';
	$this->assertTrue($this->isElementPresent($element));

  	$element = '//a[@id="jspc_incomplete_link_10"]';
  	$this->assertTrue($this->isElementPresent($element));

  	// Disable the jspc module
  	$this->changeModuleState("mod_jspc",0);
  	$this->verifyModuleState("mod_jspc",false);
  	
   	$this->changePluginState("jspc",1);
  	$this->verifyPluginState("jspc",true);
  	
  	$this->open(JOOMLA_LOCATION."index.php?option=com_community&view=profile");
  	$this->waitPageLoad();
  	
  	$element = '//img[@src="/'.JOOMLA_FOLDER.'/media/system/images/jspc/plg_56.5.jpg"]'; 
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$this->assertTrue($this->isTextPresent("Add 6 Album"));
  	$this->assertTrue($this->isTextPresent("Add 4 Album2"));
  	$this->assertTrue($this->isTextPresent("Create 3 Group"));
  	$this->assertTrue($this->isTextPresent("Join 3 Group"));
  	
	$element = '//a[@id="jspc_incomplete_link_1"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$element = '//a[@id="jspc_incomplete_link_8"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$element = '//a[@id="jspc_incomplete_link_2"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$element = '//a[@id="jspc_incomplete_link_5"]';
	$this->assertTrue($this->isElementPresent($element));
	
	$element = '//a[@id="jspc_incomplete_link_10"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$this->changeModuleState("mod_jspc",1);
  	$this->verifyModuleState("mod_jspc",true); 
  }
}
