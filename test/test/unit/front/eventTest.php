<?php
class EventTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testEventOnZero()
	{
		$compare['fillValue']=0;
		$compare['totalValue']=100;
		$compare['percentage']=0;
		$compare['incomplete']=100;
		$compare['remain']=10;
		$this->verifyPercentage(62,1,$compare);
	}
	
	function testEvent()
	{
		$compare['fillValue']=50;
		$compare['totalValue']=100;
		$compare['percentage']=50;
		$compare['incomplete']=50;
		$compare['remain']=5;
		$this->verifyPercentage(62,1,$compare);
	}
	
	function testEventOnLast()
	{
		$compare['fillValue']=100;
		$compare['totalValue']=100;
		$compare['percentage']=100;
		$compare['incomplete']=0;
		$compare['remain']=0;
		$this->verifyPercentage(62,1,$compare);
	}
}