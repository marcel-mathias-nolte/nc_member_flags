<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   NC Member Flags 
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2013
 * @website	  https://www.noltecomputer.com
 * @license   <marcel.nolte@noltecomputer.de> wrote this file. As long as you retain this notice you
 *            can do whatever you want with this stuff. If we meet some day, and you think this stuff 
 *            is worth it, you can buy me a beer in return. Meanwhile you can provide a link to my
 *            homepage, if you want, or send me a postcard. Be creative! Marcel Mathias Nolte
 */


/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['accounts']['member_flags'] = array(
	'tables' => array('tl_member_flags'),
	'icon' => 'system/modules/nc_member_flags/assets/tags.png'
);

/**
 * back end script
 */
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_MOOTOOLS'][] = '<script src="system/modules/nc_member_flags/assets/backend.js"></script>';
}

/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['user']['member_flag_toggle_button'] = 'ModuleNcMemberFlagToggleButton';

/**
 * Content elements
 */
$GLOBALS['TL_CTE']['miscellaneous']['member_flag_toggle_button'] = 'ContentNcMemberFlagToggleButton';

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('NcMemberFlagToggleHandler', 'gateKeeperContent');
$GLOBALS['TL_HOOKS']['getFrontendModule'][] = array('NcMemberFlagToggleHandler', 'gateKeeperModule');
$GLOBALS['TL_HOOKS']['getArticle'][] = array('NcMemberFlagToggleHandler', 'gateKeeperArticle');
$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('NcMemberFlagToggleHandler', 'gateKeeperPage');

?>