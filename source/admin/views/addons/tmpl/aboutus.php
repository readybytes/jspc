<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<div class="center">
	<?php require_once 'welcome.php';?>
</div>
<table>
		<tr>
				<td width="50%" valign="top">
				<div style="border: 1px solid #D5D5D5;"><?php 
				require_once 'news.php';
				?>
				</div>
				</td>
				<td width="50%" valign="top">
				<div style="border: 1px solid #D5D5D5;" ><?php
				require_once 'updates.php';
				?>
				</div>
			</td>
			</tr>
		</table>