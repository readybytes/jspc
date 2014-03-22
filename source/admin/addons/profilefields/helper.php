<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class JspcProfileFieldHelper
{
	//return all fields available in jomsocial
	static function getJomsocialProfileFields($coreParams, $addonParams, $filter = '',$join='AND')
	{	
		$integrate_with = !empty($coreParams['integrate_with']) ? $coreParams['integrate_with'] : 'jspt' ;
		$ptype			= 0;
		
		if($integrate_with == 'jspt')
			$ptype = !empty($coreParams['jspc_profiletype'])	? $coreParams['jspc_profiletype']	: 0;
		elseif($integrate_with == 'multiprofile')
			$ptype = !empty($coreParams['jspc_multiprofile'])	? $coreParams['jspc_multiprofile']	: 0;
			
		$allField = null;
		
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
				
			$sql = "SELECT * FROM " . $db->quoteName('#__community_fields');
			if(! empty($wheres)){
			   $sql .= " WHERE ".implode(' AND ', $wheres);
			}
			$sql .= " ORDER BY `ordering`";
				
			$db->setQuery($sql);
			$fields = $db->loadObjectList();
		    	
		    $xipt_exists         = JspcHelper::checkXiptExists();
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
	
	static function getFieldsHtml($coreparams, $addonparams,$fieldsPercentage,$fieldsPercentageInTotal)
	{
		$fields = self::getJomsocialProfileFields($coreparams, $addonparams);
		
		$html   = '';
		if(empty($fields)) {
			$html = "<div style=\"text-align: center; padding: 5px; \">".JspcText::_('THERE_ARE_NO_PARAMETERS_FOR_THIS_ITEM')."</div>";
			return $html;
		}

		$html .= "<table width='100%' class='table table-bordered' cellspacing='1'>";
		$html .= "<tr class='title' style=' background-color: #F4F4F4;'>";
		$html .= "<th width='30%'>".JspcText::_( 'FIELD_NAME' )."</th>";
		$html .= "<th width='20%'>".JspcText::_( 'VALUE' )."</th>";
		$html .= "<th width='20%'>".JspcText::_( 'FIELDS_WEIGHTAGE' )."</th>";			
		$html .= "<th width='25%'>".JspcText::_( 'CONTRIBUTION_IN_OVERALL_COMPLETENESS' )."</th>";
		
		$i = 0;
		foreach($fields as $f) {
			if($f->published) {
				++$i;
				$html .= "<tr class='row". $i%2 ."'>";
				
				if($f->type == 'group'){
					$html .= "<td width='40%' style=' background-color: #F4F4F4;' class='paramlist_key'><span class='editlinktip'>";
					$html .= "<b>".$f->name."</b></td>";
					$html .= "<td colspan='3' style=' background-color: #F4F4F4;'></td>";
				}else {
					$html .= "<td width='40%' class='paramlist_key'><span class='editlinktip'>";
					$html .= $f->name."</td>";
				}
				
				if($f->type != 'group') {
					$value = addonFactory::getValueFromParams($f->id, $addonparams, 0);
					$html .= "<td class='paramlist_value center'><input type='text' name='addonparams[".$f->id."]' id='addonparams[".$f->id."]' value='".$value."' /></td>";
					$html .= "<td class='paramlist_value center'>".$fieldsPercentage[$f->id]."</td>";
					$html .= "<td class='paramlist_value center'>".$fieldsPercentageInTotal[$f->id]." % </td>";
				}
				
				$html .= "</tr>";
			}
		}
		
		$html .= "</table>";
		return $html;
	}

	/* in which contain from which parameter we want to calculate */
	static function calculatePercentage($inwhich,$fieldstotal,$fieldvalue,$offset=2)
	{
		if(0 == $fieldstotal)
			return 0;
		
		$percentage = ( $fieldvalue / $fieldstotal ) * $inwhich;
		$percentage = round($percentage,$offset);
		return $percentage;
	}
	
	static function calculateTotal($addonparams,$fields,$userid)
	{
		//if userid means we have to calculate fields percentage according to
		//user profiletype or accseibility
		/* if no user then calculate all fields total */
		$total = 0;
		if(empty($fields))
			return $total;
			
		foreach($fields as $f) {
			if($f->type != 'group' && $f->published == 1) {
				$value = addonFactory::getValueFromParams($f->id, $addonparams, 0);
				$total = $total + $value;
			}
		}
		
		return $total;
	}
}
