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
 * Content elements
 */
$GLOBALS['TL_LANG']['CTE']['member_flag_toggle_button'] = array('Member Flag Button', 'Button for switching member flags.');

/**
 * Front end modules
 */
$GLOBALS['TL_LANG']['FMD']['member_flag_toggle_button'] = array('Member Flag Button', 'Button for switching member flags.');


/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['depend_on_member_flag_states'][0] = 'Flag will be ignored';
$GLOBALS['TL_LANG']['MSC']['depend_on_member_flag_states'][1] = 'Flag has to be active';
$GLOBALS['TL_LANG']['MSC']['depend_on_member_flag_states'][2] = 'Flag must not be active';

?>