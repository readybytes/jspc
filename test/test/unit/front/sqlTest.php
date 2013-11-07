<?php 
class sqlTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testSqlAddon()
	{
		$compare['fillValue']  = 100;
		$compare['totalValue'] = 100;
		$compare['percentage'] = 100;
		$compare['incomplete'] = 0;
		$compare['remain']=0;
		$this->verifyPercentage(63,1,$compare);
	}
	
}	