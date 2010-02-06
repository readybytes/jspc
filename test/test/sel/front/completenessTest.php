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
  	$element = '//img[@src="/'.JOOMLA_FOLDER.'/components/com_jspc/jspc/mod_58.jpg"]'; 
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$this->assertTrue($this->isTextPresent("Add 6 Album"));
  	$this->assertTrue($this->isTextPresent("Add 4 Album2"));
  	$this->assertTrue($this->isTextPresent("Create 3 Group"));
  	$this->assertTrue($this->isTextPresent("Join 3 Group"));
  	
  	$element = '//a[@href="/'.JOOMLA_FOLDER.'/index.php?option=com_community&view=photos&task=newalbum"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$element = '//a[@href="/'.JOOMLA_FOLDER.'/index.php?option=com_community&view=groups&task=create"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
	$element = '//a[@href="/'.JOOMLA_FOLDER.'/index.php?option=com_community&view=groups"]';
  	$this->assertTrue($this->isElementPresent($element));

  	
  	// Disable the jspc module
   	$this->changeModuleState("mod_jspc",0);
  	$this->verifyModuleState("mod_jspc",false);
  	$this->open(JOOMLA_LOCATION."index.php?option=com_community&view=profile");
  	$this->waitPageLoad();
  	
  	$element = '//img[@src="/'.JOOMLA_FOLDER.'/components/com_jspc/jspc/plg_58.jpg"]'; 
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$this->assertTrue($this->isTextPresent("Add 6 Album"));
  	$this->assertTrue($this->isTextPresent("Add 4 Album2"));
  	$this->assertTrue($this->isTextPresent("Create 3 Group"));
  	$this->assertTrue($this->isTextPresent("Join 3 Group"));
  	
  	$element = '//a[@href="/'.JOOMLA_FOLDER.'/index.php?option=com_community&view=photos&task=newalbum"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	$element = '//a[@href="/'.JOOMLA_FOLDER.'/index.php?option=com_community&view=groups&task=create"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
	$element = '//a[@href="/'.JOOMLA_FOLDER.'/index.php?option=com_community&view=groups"]';
  	$this->assertTrue($this->isElementPresent($element));
  	
  	// again enable jspc module
  	$this->changeModuleState("mod_jspc",1);
  	$this->verifyModuleState("mod_jspc",true); 	
  	
  }
}