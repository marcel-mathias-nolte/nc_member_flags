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
$GLOBALS['TL_LANG']['tl_member_flags']['title']     = array('Bezeichnung', 'Bitte geben Sie die Bezeichnung für die Auszeichnung ein.');
$GLOBALS['TL_LANG']['tl_member_flags']['icon']      = array('"Aktiv"-Symbol', 'Wählen Sie bitte das Icon, welches eine aktivierte Auszeichnung signalisiert.');
$GLOBALS['TL_LANG']['tl_member_flags']['invisible'] = array('Auszeichnung verstecken', 'Die Auszeichnung nicht in der Mitgliederliste anzeigen.');
$GLOBALS['TL_LANG']['tl_member_flags']['icon2']     = array('"Inaktiv"-Symbol', 'Wählen Sie bitte das Icon, welches eine deaktivierte Auszeichnung signalisiert.');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_member_flags']['title_legend'] = 'Bezeichnung und Symbole';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_member_flags']['new']        = array('Neue Auszeichnung', 'Eine neue Auszeichnung anlegen');
$GLOBALS['TL_LANG']['tl_member_flags']['show']       = array('Auszeichnungsdetails', 'Details der Auszeichnung ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_member_flags']['edit']       = array('Auszeichnung bearbeiten', 'Auszeichnung ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_member_flags']['cut']        = array('Auszeichnung verschieben', 'Auszeichnung ID %s verschieben');
$GLOBALS['TL_LANG']['tl_member_flags']['copy']       = array('Auszeichnung duplizieren', 'Auszeichnung ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_member_flags']['delete']     = array('Auszeichnung löschen', 'Auszeichnung ID %s löschen');
$GLOBALS['TL_LANG']['tl_member_flags']['toggle']     = array('Auszeichnung akitivieren/deaktivieren', 'Auszeichnung ID %s aktivieren/deaktivieren');
$GLOBALS['TL_LANG']['tl_member_flags']['pasteafter'] = array('Einfügen nach', 'Nach der Auszeichnung ID %s einfügen');

?>