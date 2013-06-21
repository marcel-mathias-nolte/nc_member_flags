<?php

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
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'NC',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Elements
	'NC\ContentNcMemberFlagToggleButton' => 'system/modules/nc_member_flags/elements/ContentNcMemberFlagToggleButton.php',

	// Classes
	'NC\NcMemberFlagToggleHandler'       => 'system/modules/nc_member_flags/classes/NcMemberFlagToggleHandler.php',

	// Modules
	'NC\ModuleNcMemberFlagToggleButton'  => 'system/modules/nc_member_flags/modules/ModuleNcMemberFlagToggleButton.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'member_flag_toggle_button_default' => 'system/modules/nc_member_flags/templates',
));
