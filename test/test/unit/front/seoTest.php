<?php
class SeoTest extends XiUnitTestCase
{
	
function getSqlPath()
    {
	      return dirname(__FILE__).'/sql/'.__CLASS__;
	}
function testPathOnSeoEnable()
	{	
	$filter['sef']=1;
	$this->updateJoomlaConfig($filter);
		
	//test add album path
	require_once(JPATH_ROOT.DS.'components'.DS.'com_jspc'.DS.'includes.jspc.php');
	
	$filter = array();
	$filter['published'] = 1;
	$allPublishFeature = addonFactory::getAddonsInfo($filter);
	foreach($allPublishFeature as $feature) {
			$featureObject = JspcLibrary::getFeatureIDAddonObject($feature->id);
			$completionLink[$feature->id]=$featureObject->getCompletionLink(63);
	}
		
	$info[1]= JRoute::_('/usr/bin/index.php/jomsocial/photos/newalbum');
	$info[3]= JRoute::_('/usr/bin/index.php/jomsocial/photos/uploader');
	$info[4]= JRoute::_('/usr/bin/index.php/jomsocial/profile/uploadAvatar');
	$info[6]= JRoute::_('/usr/bin/index.php/jomsocial/0-a-guest/videos');
	
	foreach($allPublishFeature as $feature)
		$this->assertEquals($completionLink[$feature->id]['link'], $info[$feature->id]);
	
	$filter['sef']=0;
	$this->updateJoomlaConfig($filter);
	}
	
	
	
function testPathOnSeoDisable()
	{
		
		$url = dirname(__FILE__).'/sql/'.__CLASS__.'/testPathOnSeoEnable.start.sql';
        $this->_DBO->loadSql($url);
			
    $filter['sef']=0;
	$this->updateJoomlaConfig($filter);
	
	//test add album path
	require_once(JPATH_ROOT.DS.'components'.DS.'com_jspc'.DS.'includes.jspc.php');
	$filter = array();
	$filter['published'] = 1;
	$allPublishFeature = addonFactory::getAddonsInfo($filter);
	foreach($allPublishFeature as $feature) {
			$featureObject = JspcLibrary::getFeatureIDAddonObject($feature->id);
			$completionLink[$feature->id]=$featureObject->getCompletionLink(63);
	}
	
	if(TEST_JSPC_JOOMLA_16){
		$info[1]= JRoute::_('index.php?option=com_community&view=photos&task=newalbum&Itemid=133');
		$info[3]= JRoute::_('index.php?option=com_community&view=photos&task=uploader&Itemid=133');
		$info[4]= JRoute::_('index.php?option=com_community&view=profile&task=uploadAvatar&Itemid=133');
		$info[6]= JRoute::_('index.php?option=com_community&view=videos&task=myvideos&Itemid=133');
	}
	
	if(TEST_JSPC_JOOMLA_15){
		$info[1]= JRoute::_('index.php?option=com_community&view=photos&task=newalbum&Itemid=53');
		$info[3]= JRoute::_('index.php?option=com_community&view=photos&task=uploader&Itemid=53');
		$info[4]= JRoute::_('index.php?option=com_community&view=profile&task=uploadAvatar&Itemid=53');
		$info[6]= JRoute::_('index.php?option=com_community&view=videos&task=myvideos&Itemid=53');
	}
	
	foreach($allPublishFeature as $feature)
		$this->assertEquals($completionLink[$feature->id]['link'], $info[$feature->id]);
	
	}
	
}
	