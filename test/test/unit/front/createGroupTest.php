<?php 

class CreateGroupTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testCreateGroupOnZero()
	{
		$compare['fillValue']  = 0;
		$compare['totalValue'] = 90;
		$compare['percentage'] = 0;
		$compare['incomplete'] = 100;
		$compare['remain']=8;
		$this->verifyPercentage(63,2,$compare);			
	}
	
	function testCreateGroup()
	{
		$compare['fillValue']  = 56.25;
		$compare['totalValue'] = 90;
		$compare['percentage'] = 62.5;
		$compare['incomplete'] = 37.5;
		$compare['remain']=3;
		$this->verifyPercentage(63,2,$compare);			
	}
	
	function testCreateGroupOnLast()
	{
		$compare['fillValue']  = 90;
		$compare['totalValue'] = 90;
		$compare['percentage'] = 100;
		$compare['incomplete'] = 0;
		$compare['remain']=0;
		$this->verifyPercentage(63,2,$compare);			
	}

	
		
}
