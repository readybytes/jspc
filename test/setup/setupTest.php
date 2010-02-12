<?php
/* This testcase should run on fresh install */
class SetupTest extends XiSelTestCase
{
  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testSetupUser()
  {
  	$this->frontLogin("gaurav","gaurav");
  	$this->assertFalse($this->isTextPresent("Username and password do not match or you do not have an account yet"));
  	
  }
  
  function testSetupModuleAndPlugin()
  {
  	
  }
  
} 
    
    
