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
$GLOBALS['TL_DCA']['tl_member']['fields']['member_flags'] = array
(
	'sql'                     => 'text NULL'
);
$tl_member_flags_helper = new tl_member_flags_helper();
$tl_member_flags_fields = $tl_member_flags_helper->getDynamicFields();
if (is_array($tl_member_flags_fields) && count($tl_member_flags_fields) > 0)
{
	$tl_member_flags_be_fields = array();
	foreach ($tl_member_flags_fields as $tl_member_flags_field)
	{
		$tl_member_flags_be_fields[$tl_member_flags_field['key']] = array
		(
			'label'               => array($tl_member_flags_field['label'], $tl_member_flags_field['label']),
			'icon'                => $tl_member_flags_field['icon'],
			'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleMemberFlag(this, ' . $tl_member_flags_field['id'] . ',%s)"',
			'button_callback'     => array('tl_member_flags_helper', 'toggleFlag' . $tl_member_flags_field['id'])
		);
	}
	$GLOBALS['TL_DCA']['tl_member']['list']['operations'] = array_merge($tl_member_flags_be_fields, $GLOBALS['TL_DCA']['tl_member']['list']['operations']);
}

if (isset($_GET['member_flag_state'])) 
{
    $tl_member_flags_helper->toggleMemberFlagState();
}

/**
 * Class tl_member_flags_helper
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_member_flags_helper extends Backend
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
	 * Toggle the given flag
	 */
    public function toggleMemberFlagState() 
	{
        $id = (int)$_GET['item'];
        $state = (bool)$_GET['member_flag_state'];
        $flag = (int)$_GET['flag_id'];

		$this->createInitialVersion('tl_member', $intId);
		
		$objFlags = $this->Database->prepare("SELECT `member_flags` FROM `tl_member` WHERE `id` = ?")->execute($id);
		while ($objFlags->next())
		{
			$flags = @unserialize($objFlags->member_flags);
		}
		$val = (is_array($flags) && isset($flags[$flag])) ? $flags[$flag] : 0;
		
		if (is_array($flags))
		{
			$flags[$flag] = $val > 0 ? 0 : 1;
		}
		else
		{
			$flags = array($flag => $val > 0 ? 0 : 1);
		}
        $this->Database->prepare('UPDATE `tl_member` SET `member_flags` = ? WHERE id = ? LIMIT 1;')->execute(serialize($flags), $id)->execute();
		$this->createNewVersion('tl_member', $id);
		$this->log('A new version of record "tl_member.id='.$id.'" has been created', 'tl_member toggleMemberFlagState()', TL_GENERAL);
    }

	/**
	 * Get the dca opration arrays
	 * @param int
	 * @return array
	 */
	public function getDynamicFields($id = 0)
	{
		if ($this->Database->prepare("SHOW TABLES LIKE 'tl_member_flags'")->execute()->next())
		{
			if ($id > 0)
			{
				$objDynamicFields = @$this->Database->prepare("SELECT * FROM `tl_member_flags` WHERE `id` = ?")->execute($id);
				while ($objDynamicFields && $objDynamicFields->next())
				{
					return array(
						'label' => $objDynamicFields->title,
						'icon' => \FilesModel::findByPk($objDynamicFields->icon)->path,
						'icon2' => \FilesModel::findByPk($objDynamicFields->icon2)->path,
						'key' => 'flag_' . $objDynamicFields->id,
						'id' => $objDynamicFields->id
					);
				}
			}
			$objDynamicFields = @$this->Database->prepare("SELECT * FROM `tl_member_flags` WHERE `invisible` != '1' ORDER BY sorting")->execute();
			$dynamicFields = array();
			while ($objDynamicFields && $objDynamicFields->next())
			{
				$dynamicFields[$objDynamicFields->id] = array(
					'label' => $objDynamicFields->title,
					'icon' => \FilesModel::findByPk($objDynamicFields->icon)->path,
					'icon2' => \FilesModel::findByPk($objDynamicFields->icon2)->path,
					'key' => 'flag_' . $objDynamicFields->id,
					'id' => $objDynamicFields->id
				);
			}
			return $dynamicFields;
		}
		return array();
	}
	
	/**
	 * Return the "toggle flag" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleFlag($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
			$this->redirect($this->getReferer());
		}
		
		$flags = @unserialize($row['member_flags']);
		$flag = (is_array($flags) && isset($flags[(int)func_get_arg(12)])) ? $flags[(int)func_get_arg(12)] : 0;
		
		$href .= '&amp;id='.$this->Input->get('id').'&amp;tid='.$row['id'].'&amp;state='.$flag;
		$item = $this->getDynamicFields(func_get_arg(12));
		$icon = $flag ? $item['icon'] : $item['icon2'];
		$alticon = !$flag ? $item['icon'] : $item['icon2'];
		$class = $flag ? 'active' : 'inactive';

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label,' class="' . $class . '" name="' . $alticon . '"').'</a> ';
	}
	
	/**
	 * Call functions with parameters in the function's name
	 * @param string
	 * @param array
	 * @return var
	 */
	public function __call($method, $args)
	{
		if (substr($method, 0, strlen('toggleFlag')) == 'toggleFlag')
		{
			$args[] = substr($method, strlen('toggleFlag'));
			return call_user_func_array(array($this, 'toggleFlag'), $args);
		}
	}

}

?>