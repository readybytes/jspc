<?php
class AvtarTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testAvtar()
	{
		$compare['fillValue']  = 0;
		$compare['totalValue'] = 40;
		$compare['percentage'] = 0;
		$compare['incomplete'] = 100;
		$compare['remain']=1;
		$this->verifyPercentage(63,4,$compare);
	}
	
	
}
