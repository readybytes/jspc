<?php

/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
//echo $this->pane->startPanel( JText::_('JOOMLAXI_UPDATES') , 'joomlaxi' );

?>
	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script>
new TWTR.Widget({
version: 2,
type: 'search',
search: 'JoomlaXiNews',
interval: 6000,
title: 'Latest News on JoomlaXi',
subject: 'JoomlaXi',
width: 'auto',
height: 300,
theme: {
shell: {
background: '#ffffff',
color: '#fa761e'
},
tweets: {
background: '#ffffff',
color: '#444444',
links: '#1985b5'
}
},
features: {
scrollbar: false,
loop: false,
live: false,
hashtags: true,
timestamp: true,
avatars: false,
behavior: 'all'
}
}).render().start();
</script>

<?php 
//echo $this->pane->endPanel();
