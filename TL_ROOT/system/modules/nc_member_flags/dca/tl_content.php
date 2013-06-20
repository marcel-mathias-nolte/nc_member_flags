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
$GLOBALS['TL_DCA']['tl_content']['palettes']['member_flag_toggle_button'] = '{type_legend},type,headline;{text_legend},member_flag_button_text,member_flag_id,depend_on_member_flag_state,member_flag_send_mail,member_flag_jump_to;{expert_legend:hide},member_flag_toggle_button_template,invisible,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'depend_on_member_flag';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'member_flag_send_mail';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['member_flag_send_mail'] = 'member_flag_mail_subject,member_flag_mail_text';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['depend_on_member_flag'] = 'member_flag_id,depend_on_member_flag_state';
$GLOBALS['TL_DCA']['tl_content']['fields']['member_flag_id'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['member_flag_id'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_member_flag', 'getFlags'),
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => 'int(10) NOT NULL default \'0\''
);
$GLOBALS['TL_DCA']['tl_module']['fields']['member_flag_button_text'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['member_flag_button_text'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
	'sql'                     => 'varchar(255) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_content']['fields']['depend_on_member_flag'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['depend_on_member_flag'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => 'char(1) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_content']['fields']['depend_on_member_flag_state'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['depend_on_member_flag_state'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array(0,1,2),
	'reference'               => &$GLOBALS['TL_LANG']['MSC']['depend_on_member_flag_states'],
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
	'sql'                     => 'int(10) NOT NULL default \'0\''
);
$GLOBALS['TL_DCA']['tl_content']['fields']['member_flag_send_mail'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['member_flag_send_mail'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr'),
	'sql'                     => 'char(1) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_content']['fields']['member_flag_mail_subject'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['member_flag_mail_subject'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>255, 'tl_class'=>'long'),
	'sql'                     => 'varchar(255) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_content']['fields']['member_flag_mail_text'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['member_flag_mail_text'],
	'exclude'                 => true,
	'inputType'               => 'textarea',
	'eval'                    => array('mandatory'=>true, 'preserveTags'=>true, 'decodeEntities'=>true, 'tl_class'=>'clr'),
	'sql'                     => 'text NULL'
);
$GLOBALS['TL_DCA']['tl_content']['fields']['member_flag_toggle_button_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['member_flag_toggle_button_template'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_member_flag', 'getGalleryTemplates'),
	'sql'                     => 'varchar(64) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_content']['fields']['member_flag_jump_to'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['member_flag_jump_to'],
	'inputType'               => 'pageTree',
	'foreignKey'              => 'tl_page.title',
	'eval'                    => array('fieldType'=>'radio'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'relation'                => array('type'=>'hasOne', 'load'=>'eager')
);

$GLOBALS['TL_HOOKS']['loadDataContainer'][] = array('tl_content_member_flag', 'extendPalettes');

/**
 * Class tl_content_member_flag
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_content_member_flag extends Backend
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
	 */
	public function extendPalettes($strName)
	{
		if ($strName != 'tl_content')
		{
			return;
		}
		foreach (array_keys($GLOBALS['TL_DCA']['tl_content']['palettes']) as $key)
		{
			if ($key != 'member_flag_toggle_button' && $key != '__selector__')
			{
				$GLOBALS['TL_DCA']['tl_content']['palettes'][$key] = strtr($GLOBALS['TL_DCA']['tl_content']['palettes'][$key], array('{expert_legend:hide}' => '{expert_legend:hide},depend_on_member_flag'));
			}
		}
	}
	
	/**
	 * Return all templates as array
	 * @param DataContainer
	 * @return array
	 */
	public function getGalleryTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('member_flag_toggle_button_', $intPid);
	}
}

?>