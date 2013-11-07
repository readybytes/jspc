<?php 

class AlbumTest extends XiUnitTestCase
{
	
	function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testAlbumOnZero()
	{
		$compare['fillValue']  = 0;
		$compare['totalValue'] = 100;
		$compare['percentage'] = 0;
		$compare['incomplete'] = 100;
		$compare['remain']=8;
		$this->verifyPercentage(63,1,$compare);
	}
	
	function testAlbum()
	{
		$compare['fillValue']  = 37.5;
		$compare['totalValue'] = 100;
		$compare['percentage'] = 37.5;
		$compare['incomplete'] = 62.5;
		$compare['remain']=5;
		$this->verifyPercentage(63,1,$compare);
	}
	
	function testAlbumOnLast()
	{
		$compare['fillValue']  = 100;
		$compare['totalValue'] = 100;
		$compare['percentage'] = 100;
		$compare['incomplete'] = 0;
		$compare['remain']=0;
		$this->verifyPercentage(63,1,$compare);
	}
		
			
}
