<?php
class ProfileTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testProfileOnZero()
	{
		$compare['fillValue']  = 0;
		$compare['totalValue'] = 80;
		$compare['percentage'] = 0;
		$compare['incomplete'] = 100;
		$compare['remain']=13;
		$this->verifyPercentage(63,7,$compare);			
	}
	
	function testProfile()
	{
		$compare['fillValue']  = 64;
		$compare['totalValue'] = 80;
		$compare['percentage'] = 80;
		$compare['incomplete'] = 20;
		$compare['remain']=3;
		$this->verifyPercentage(63,7,$compare);			
	}
	
	function testProfileOnLast()
	{
		$compare['fillValue']  = 80;
		$compare['totalValue'] = 80;
		$compare['percentage'] = 100;
		$compare['incomplete'] = 0;
		$compare['remain']=0;
		$this->verifyPercentage(63,7,$compare);			
	}
}
