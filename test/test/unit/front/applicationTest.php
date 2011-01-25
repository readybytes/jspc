<?php

class ApplicationTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testApplicationOnZero()
	{
		$compare['fillValue']  = 0;
		$compare['totalValue'] = 10;
		$compare['percentage'] = 0;
		$compare['incomplete'] = 100;
		$compare['remain']=5;
		$this->verifyPercentage(62,4,$compare);
	}
	
	function testApplication()
	{
		$compare['fillValue']=4;
		$compare['totalValue']=10;
		$compare['percentage']=40;
		$compare['incomplete']=60;
		$compare['remain']=3;
		$this->verifyPercentage(62,4,$compare);
	}
	
	function testApplicationOnLast()
	{
		$compare['fillValue']=10;
		$compare['totalValue']=10;
		$compare['percentage']=100;
		$compare['incomplete']=0;
		$compare['remain']=0;
		$this->verifyPercentage(62,4,$compare);
	}
}