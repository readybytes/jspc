<?php
class GroupMemberTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}


	function testGroupMemberOnZero()
	{
		$compare['fillValue']  = 0;
		$compare['totalValue'] = 70;
		$compare['percentage'] = 0;
		$compare['incomplete'] = 100;
		$compare['remain']=9;
		$this->verifyPercentage(63,5,$compare);			
	}

	function testGroupMember()
	{
		$compare['fillValue']  = 46.67;
		$compare['totalValue'] = 70;
		$compare['percentage'] = 66.7;
		$compare['incomplete'] = 33.3;
		$compare['remain']=3;
		$this->verifyPercentage(63,5,$compare);			
	}
	
	function testGroupMemberOnLast()
	{
		$compare['fillValue']  = 70;
		$compare['totalValue'] = 70;
		$compare['percentage'] = 100;
		$compare['incomplete'] = 0;
		$compare['remain']=0;
		$this->verifyPercentage(63,5,$compare);			
	}
}