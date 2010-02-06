<?php
class ProfileCompletenessTest extends XiSelTestCase 
{

  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testAddFeatures()
  {
  	$this->_DBO->addTable('#__jspc_addons');
  	$this->_DBO->filterColumn('#__jspc_addons','id');
  	$this->adminLogin();
  	
  	$this->addFeatureOne();
  	$this->addFeatureTwo();
  	$this->addFeatureThree();
  	
  }
  
  function testPublish()
  {
  	$this->_DBO->addTable('#__jspc_addons');
  	$this->_DBO->filterColumn('#__jspc_addons','id');
  	
  	$this->adminLogin();
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_jspc");
  	$this->waitPageLoad();
  	$this->click("//td[@id='published1']/a");
    $this->waitPageLoad();
  	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  	
  	$this->click("//td[@id='published2']/a");
    $this->waitPageLoad();
  	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  	
  	$this->click("//td[@id='published3']/a");
    $this->waitPageLoad();
  	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  	
  	$this->click("//td[@id='published3']/a");
    $this->waitPageLoad();
  	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  }
	
  function testUnpublish()
  {
  	$this->_DBO->addTable('#__jspc_addons');
  	$this->_DBO->filterColumn('#__jspc_addons','id');
  	
  	$this->adminLogin();
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_jspc");
  	$this->waitPageLoad();
  	$this->click("//td[@id='published1']/a");
    $this->waitPageLoad();
  	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  	
  	$this->click("//td[@id='published2']/a");
    $this->waitPageLoad();
  	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  	
  	$this->click("//td[@id='published3']/a");
    $this->waitPageLoad();
  	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  	
  	$this->click("//td[@id='published3']/a");
    $this->waitPageLoad();
  	$this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  }
  
  function testEditFeature()
  {
  	$this->_DBO->addTable('#__jspc_addons');
  	$this->_DBO->filterColumn('#__jspc_addons','id');
  	$this->adminLogin();
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_jspc&view=addons");
    $this->waitPageLoad();
    
    $this->click("//span[@id='featurename1']/a");
    $this->waitPageLoad();
   	$this->type("coreparamsjspc_core_total_contribution", "200");
    $this->type("addonparamsalbum_total", "20");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
  	$this->click("//td[@id='published1']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
    
    $this->click("//span[@id='featurename3']/a");
    $this->waitPageLoad();
   	$this->type("coreparamsjspc_core_total_contribution", "200");
    $this->type("addonparams[2]", "20");
    $this->type("addonparams[3]", "20");
    $this->type("addonparams[4]", "20");
    $this->type("addonparams[5]", "20");
    $this->type("addonparams[7]", "20");
    $this->type("addonparams[8]", "20");
    $this->type("addonparams[9]", "20");
    $this->type("addonparams[10]", "20");
    $this->type("addonparams[11]", "20");
    $this->type("addonparams[12]", "20");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
  	$this->click("//td[@id='published3']/a");
    $this->waitPageLoad();
    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
    
  }
  
  function testDelete()
  {
  	$this->_DBO->addTable('#__jspc_addons');
  	$this->_DBO->filterColumn('#__jspc_addons','id');
  	$this->adminLogin();
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_jspc&view=addons");
    $this->waitPageLoad();
    $this->click("cb2");
    $this->click("//td[@id='toolbar-trash']/a/span");
    $this->assertTrue((bool)$this->getConfirmation());
    
    $this->waitPageLoad();
    $this->click("cb1");
    $this->click("//td[@id='toolbar-trash']/a/span");
    $this->assertTrue((bool)$this->getConfirmation());
    $this->assertTrue($this->isElementPresent("//dl[@id='system-message']/dd/ul/li"));
  }
  
  function addFeatureOne()
  {
  	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_jspc&view=addons");
    $this->click("//td[@id='toolbar-new']/a/span");
    $this->waitPageLoad();
    $this->select("addon", "label=Albums");
    $this->click("//input[@type='submit']");
    $this->waitPageLoad();
    $this->type("featurename", "Album");
    $this->type("coreparamsjspc_core_total_contribution", "100");
    $this->type("coreparamsjspc_core_display_text", "Add % Album");
    $this->type("addonparamsalbum_total", "10");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
     	
  }
  
  function addFeatureTwo()
  {
  	$this->open(JOOMLA_LOCATION."administrator/index.php?option=com_jspc");
  	$this->waitPageLoad();
    $this->click("//td[@id='toolbar-new']/a/span");
    $this->waitPageLoad();
    $this->click("//input[@type='submit']");
    $this->assertTrue((bool)$this->getAlert());
    $this->select("addon", "label=Group Member");
    $this->click("//input[@type='submit']");
    $this->waitPageLoad();
    $this->type("featurename", "Group Member");
    $this->type("coreparamsjspc_core_total_contribution", "100");
    $this->type("coreparamsjspc_core_display_text", "%s Group Member");
    $this->type("addonparamsgroupmember_total", "10");
    $this->click("//td[@id='toolbar-apply']/a/span");
    $this->waitPageLoad();
    $this->click("//td[@id='toolbar-cancel']/a/span");
    $this->waitPageLoad();
    
     
  }
  
  function addFeatureThree()
  {
  	$this->open(JOOMLA_LOCATION."administrator/index.php?option=com_jspc&view=addons");
    $this->click("//td[@id='toolbar-new']/a/span");
    $this->waitPageLoad();
    $this->select("addon", "label=Profile Fields");
    $this->click("//input[@type='submit']");
    $this->waitPageLoad();
    $this->type("featurename", "Profile");
    $this->type("coreparamsjspc_core_total_contribution", "100");
    $this->type("coreparamsjspc_core_display_text", "%s Profile");
    $this->type("addonparams[2]", "10");
    $this->type("addonparams[3]", "10");
    $this->type("addonparams[4]", "10");
    $this->type("addonparams[5]", "10");
    $this->type("addonparams[7]", "10");
    $this->type("addonparams[8]", "10");
    $this->type("addonparams[9]", "10");
    $this->type("addonparams[10]", "10");
    $this->type("addonparams[11]", "10");
    $this->type("addonparams[12]", "10");
    $this->click("link=Close");
    $this->waitPageLoad();
  	
    $this->open(JOOMLA_LOCATION."administrator/index.php?option=com_jspc");
    $this->click("//td[@id='toolbar-new']/a/span");
    $this->waitPageLoad();
    $this->select("addon", "label=Profile Fields");
    $this->click("//input[@type='submit']");
    $this->waitPageLoad();
    $this->type("featurename", "Profile");
    $this->type("coreparamsjspc_core_total_contribution", "100");
    $this->type("coreparamsjspc_core_display_text", "%s Profile");
    $this->type("addonparams[2]", "10");
    $this->type("addonparams[3]", "101");
    $this->type("addonparams[3]", "10");
    $this->type("addonparams[4]", "10");
    $this->type("addonparams[5]", "10");
    $this->type("addonparams[7]", "10");
    $this->type("addonparams[8]", "10");
    $this->type("addonparams[9]", "10");
    $this->type("addonparams[10]", "10");
    $this->type("addonparams[11]", "10");
    $this->type("addonparams[12]", "10");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
     
  }
}



    
