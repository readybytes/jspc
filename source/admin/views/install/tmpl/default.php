<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.framework');
?>

<!--Congratulation Message-->
<div class="row-fluid">
  
  <div class="row-fluid">
    <div class="alert alert-success center">
      <h2><em><?php echo Rb_Text::_('COM_JSPC_INSTALLATION_SUCCESS_MSG');?></em></h2>
      <h3><?php echo Rb_Text::_('COM_JSPC_INSTALLATION_SUCCESS_MSG_CONTENT');?></h3>
    </div>
  </div>
    
  <div class="row-fluid">
    <button type="submit" class="btn btn-success btn-large pull-right" onclick="window.location.href='<?php echo JUri::base().'index.php?option=com_jspc&view=install&task=complete';?>';">
      <i class="icon-hand-right"></i>&nbsp;<?php echo Rb_Text::_('COM_JSPC_FINISH_INSTALLATION_BUTTON');?>
    </button>
     </div>  
  
</div>


<div class="row-fluid">
  <div class="hide">
    <?php
      $version = new JVersion();
      $suffix = 'jom=J'.$version->RELEASE.'&utm_campaign=broadcast&jspc=JSPC'.JSPC_VERSION.'&dom='.JURI::getInstance()->toString(array('scheme', 'host', 'port'));?>
      <iframe src="http://pub.joomlaxi.com/broadcast/jspc/installation.html?<?php echo $suffix?>"></iframe>
  </div>
</div>
<?php  

