<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class helper
{

	//return all fields available in jomsocial
	function getJomsocialProfileFields($filter = '',$join='AND')
	{
		$integrate_with = jspcAddons::getCoreParams('integrate_with', 'jspt');
		
		if($integrate_with == 'jspt')
			$ptype=jspcAddons::getCoreParams('jspc_profiletype',0);
		else
			$ptype=jspcAddons::getCoreParams('jspc_multiprofile',0);
			
		$allField=null;
		
		if($allField == null){
			$db	= JFactory::getDBO();
			
			//setting up the search condition is there is any
			$wheres = array();
			if(! empty($filter)){
				foreach($filter as $column => $value)
				{
					$wheres[] = "`$column` = " . $db->Quote($value); 	
				}
			}
				
			$sql = "SELECT * FROM " . $db->nameQuote('#__community_fields');
			if(! empty($wheres)){
			   $sql .= " WHERE ".implode(' AND ', $wheres);
			}
			$sql .= " ORDER BY `ordering`";
				
			$db->setQuery($sql);
			$fields = $db->loadObjectList();
		    	
		    $xipt_exists = JspcHelper::checkXiptExists();
		    $multiprofile_exists = JspcHelper::checkMultiProfileExists();
		    
		    if($xipt_exists && $ptype != 0 && $integrate_with == 'jspt'){
		    	$result  = XiptWrapper::filterProfileTypeFields($fields,$ptype,null);
		    }
		    elseif($multiprofile_exists && $ptype != 0 && $integrate_with == 'multiprofile'){
		    	$result  = MultiProfile::filterProfileTypeFields($fields,$ptype);
		    }
	    }
		return $fields;
		
	}
	
	function getFieldsHtml($addonparams,$fieldsPercentage,$fieldsPercentageInTotal)
	{
		$fields = self::getJomsocialProfileFields();
		$html = '';
		if(empty($fields)) {
			$html = "<div style=\"text-align: center; padding: 5px; \">".JspcText::_('THERE_ARE_NO_PARAMETERS_FOR_THIS_ITEM')."</div>";
			return $html;
		}

		$html .= "<table width='100%' class='paramlist admintable' cellspacing='1'>";
		$html .= "<tr class='title'>";
		$html .= "<th width='30%'>".JspcText::_( 'FIELD_NAME' )."</th>";
		$html .= "<th width='20%'>".JspcText::_( 'VALUE' )."</th>";
		$html .= "<th width='20%'>".JspcText::_( 'FIELDS_WEIGHTAGE' )."</th>";			
		$html .= "<th width='25%'>".JspcText::_( 'CONTRIBUTION_IN_OVERALL_COMPLETENESS' )."</th>";
		
		$i = 0;
		foreach($fields as $f) {
			if($f->published) {
				++$i;
				$html .= "<tr class='row". $i%2 ."'>";
				$html .= "<td width='40%' class='paramlist_key'><span class='editlinktip'>";
				$html .= $f->name."</td>";
				if($f->type != 'group') {
					$html .= "<td class='paramlist_value'><input type='text' name='addonparams[".$f->id."]' id='addonparams[".$f->id."]' value='".$addonparams->get($f->id,0)."'/></td>";
					$html .= "<td class='paramlist_value'>".$fieldsPercentage[$f->id]."</td>";
					$html .= "<td class='paramlist_value'>".$fieldsPercentageInTotal[$f->id]." % </td>";
				}
				
				//$html .= "<input type='text' id='params[".$f->id."]' name='params[".$f->id."]' value='' />";
				$html .= "</tr>";
			}
		}
		
		$html .= "</table>";
		return $html;
	}

	/* in which contain from which parameter we want to calculate */
	function calculatePercentage($inwhich,$fieldstotal,$fieldvalue,$offset=2)
	{
		if(0 == $fieldstotal)
			return 0;
		
		$percentage = ( $fieldvalue / $fieldstotal ) * $inwhich;
		$percentage = round($percentage,$offset);
		return $percentage;
	}
	
	
	function calculateTotal($addonparams,$fields,$userid)
	{
		//if userid means we have to calculate fields percentage according to
		//user profiletype or accseibility
		/* if no user then calculate all fields total */
		$total = 0;
		if(empty($fields))
			return $total;
			
		foreach($fields as $f) {
			if($f->type != 'group' && $f->published == 1) {
				$value = $addonparams->get($f->id,0);
				$total = $total + $value;
			}
		}
		
		return $total;
	}
}
