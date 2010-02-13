<?php

class InstallXiptTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

   /**
   */
  function testXiptInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // first copy a dummy old AEC MI, so that we can test that file 
    // does not exist after the migration
    jimport( 'joomla.filesystem.file' );
    jimport( 'joomla.filesystem.folder' );
    $AEC_MI_PATH = dirname( JPATH_ROOT ) . DS. 'components' . DS . 'com_acctexp' . DS . 'micro_integration';
	$AEC_MI_FILE = $AEC_MI_PATH .DS.'mi_jomsocialjspt.php';
	if(JFolder::exists($AEC_MI_PATH))
		$this->assertTrue(JFile::write($AEC_MI_FILE, "Dummy files"));
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad("30000");
      
	// add profiletype-one
    $this->type("install_url", COM_XIPT_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
   
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
      
    $this->type("install_url", PLG_XIPT_SYS_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
    
    	// add profiletype-one
    $this->type("install_url", PLG_XIPT_COM_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Plugin Success"));
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
    
    //enable xipt plugins also, uninstallation will again disable them
    $sql = "UPDATE `#__plugins` SET `published` = '1' WHERE `folder` ='community';";
    $this->_DBO->execSql($sql);
  }
}

