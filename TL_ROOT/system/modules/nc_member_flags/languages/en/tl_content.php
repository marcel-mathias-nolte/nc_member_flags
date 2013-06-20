<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   NC Registration Admin Notification 
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
$GLOBALS['TL_LANG']['tl_content']['member_flag_button_text']            = array('Button text', 'Here you can enter the buttons\'s title.');
$GLOBALS['TL_LANG']['tl_content']['member_flag_id']                     = array('Member Flag', 'Please choose the checked (changed) member flag.');
$GLOBALS['TL_LANG']['tl_content']['depend_on_member_flag']              = array('Visibility depends on member flag', 'Check, if the element should only be visible if a member flag has a specific state.');
$GLOBALS['TL_LANG']['tl_content']['depend_on_member_flag_state']        = array('Needed state', 'Flag state, which enables visibility.');
$GLOBALS['TL_LANG']['tl_content']['member_flag_send_mail']              = array('Send a notification email', 'Send an email, if the value changed.');
$GLOBALS['TL_LANG']['tl_content']['member_flag_mail_subject']           = array('Email message subject', 'Please enter the email subject. The first occurence of %s will be replaced by the website\'s domain.');
$GLOBALS['TL_LANG']['tl_content']['member_flag_mail_text']              = array('Email message text', 'Please enter the email content. Valid placeholders are {name} and {id} of the user, {flag} and {state} as name and value of the flag.');
$GLOBALS['TL_LANG']['tl_content']['member_flag_jump_to']                = array('Redirection target', 'Please choose a redirection target.');
$GLOBALS['TL_LANG']['tl_content']['member_flag_toggle_button_template'] = array('Template', 'Please choose a template.');

?>