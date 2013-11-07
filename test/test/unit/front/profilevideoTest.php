<?php
class ProfileVideoTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testProfileVideo()
	{
		$compare['fillValue']=0;
		$compare['totalValue']=5;
		$compare['percentage']=0;
		$compare['incomplete']=100;
		$compare['remain']=1;
		$this->verifyPercentage(62,2,$compare);
	}
	
	function testProfileVideoAfterAdd()
	{
		// for caching purpose
		$my	= CFactory::getUser(62, '');
			
		$compare['fillValue']=5;
		$compare['totalValue']=5;
		$compare['percentage']=100;
		$compare['incomplete']=0;
		$compare['remain']=0;
		$this->verifyPercentage(62,2,$compare);
		
	}
}