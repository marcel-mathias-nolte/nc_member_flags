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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_article']['member_flag_id']              = array('Member Flag', 'Please choose the checked (changed) member flag.');
$GLOBALS['TL_LANG']['tl_article']['depend_on_member_flag']       = array('Visibility depends on member flag', 'Check, if the element should only be visible if a member flag has a specific state.');
$GLOBALS['TL_LANG']['tl_article']['depend_on_member_flag_state'] = array('Needed state', 'Flag state, which enables visibility.');

?>