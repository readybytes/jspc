<?php
/* This testcase should run on fresh install */
class SetupTest extends XiUnitTestCase 
{
  //define this function if you require DB setup
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function testSetupUser()
  {
  }
} 
    
    