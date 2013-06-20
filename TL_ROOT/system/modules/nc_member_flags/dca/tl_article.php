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
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'depend_on_member_flag';
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['depend_on_member_flag'] = 'member_flag_id,depend_on_member_flag_state';
$GLOBALS['TL_DCA']['tl_article']['fields']['member_flag_id'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['member_flag_id'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_article_member_flag', 'getFlags'),
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => 'int(10) NOT NULL default \'0\''
);
$GLOBALS['TL_DCA']['tl_article']['fields']['depend_on_member_flag'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['depend_on_member_flag'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => 'char(1) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_article']['fields']['depend_on_member_flag_state'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['depend_on_member_flag_state'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array(0,1,2),
	'reference'               => &$GLOBALS['TL_LANG']['MSC']['depend_on_member_flag_states'],
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
	'sql'                     => 'int(10) NOT NULL default \'0\''
);

$GLOBALS['TL_HOOKS']['loadDataContainer'][] = array('tl_article_member_flag', 'extendPalettes');

/**
 * Class tl_article_member_flag
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_article_member_flag extends Backend
{

	/**
	 * Initialization and necessary imports
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	
	/**
	 * Return all visible flags as array
	 * @return array
	 */
	public function getFlags()
	{
		$flags = array();

		$objLister = $this->Database->execute("SELECT * FROM tl_member_flags WHERE invisible <> '1' ORDER BY sorting");
		while ($objLister->next())
		{
			$flags[$objLister->id] = $objLister->title;
		}
		
		return $flags;
	}
		
	/**
	 * Extend the default palettes
	 * @return void
	 */
	public function extendPalettes($strName)
	{
		if ($strName != 'tl_article')
		{
			return;
		}
		foreach (array_keys($GLOBALS['TL_DCA']['tl_article']['palettes']) as $key)
		{
			if ($key != '__selector__')
			{
				$GLOBALS['TL_DCA']['tl_article']['palettes'][$key] = strtr($GLOBALS['TL_DCA']['tl_article']['palettes'][$key], array('{publish_legend},' => '{publish_legend},depend_on_member_flag,'));
			}
		}
	}
}

?>