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
	
	function testAvtarAfterUpload()
	{
		$compare['fillValue']  = 40;
		$compare['totalValue'] = 40;
		$compare['percentage'] = 100;
		$compare['incomplete'] = 0;
		$compare['remain']=0;
		$this->verifyPercentage(64,4,$compare);
	}
	
}
