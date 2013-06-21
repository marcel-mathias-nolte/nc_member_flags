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
 * Run in a custom namespace, so the class can be replaced
 */
namespace NC;

/**
 * Class ModuleNcMemberFlagToggleButton
 *
 * Front end module "MemberFlagToggleButton".
 */
class ModuleNcMemberFlagToggleButton extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'member_flag_toggle_button_default';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### MEMBER FLAG TOGGLE BUTTON ###';
			return $objTemplate->parse();
		}
		if (!FE_USER_LOGGED_IN)
		{
			return '';
		}
		if ($this->member_flag_toggle_button_template)
		{
			$this->strTemplate = $this->member_flag_toggle_button_template;
		}
		return parent::generate();
	}
	
	/**
	 * Generate the module
	 */
	protected function compile()
	{

		// Create new user if there are no errors
		if ($this->Input->post('FORM_SUBMIT') == 'member_flag_toggle_button' && FE_USER_LOGGED_IN)
		{
			$this->import('FrontendUser', 'User');
			$flags = $this->User->member_flags;
			if (is_array($flags))
			{
				$flags[$this->member_flag_id] = isset($flags[$this->member_flag_id]) && $flags[$this->member_flag_id] > 0 ? 0 : 1;
				$this->User->member_flags = $flags;
				$this->Database->prepare("UPDATE `tl_member` SET `member_flags` = ? WHERE `id` = ?")->execute(serialize($flags), $this->User->id);
				if ($this->member_flag_send_mail)
				{
					$objFlagLister = $this->Database->prepare("SELECT * FROM `tl_member_flags` WHERE `id` = ?")->execute($this->member_flag_id);
					$arrData = array('name' => $this->User->fullname, 'id' => $this->User->id, 'state' => $flags[$this->member_flag_id]);
					$arrData['flag'] = $objFlagLister->next() ? $objFlagLister->title : 'unbekannt [ID: ' . $this->member_flag_id . ']';
					$this->sendAdminNotification($arrData);
				}
				if (strlen($this->jumpTo))
				{
					$objNextPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($this->jumpTo);
					if ($objNextPage->numRows)
					{
						$this->redirect($this->generateFrontendUrl($objNextPage->fetchAssoc()));
					}
				}
			}		
		}
		
		$this->Template->enctype = 'application/x-www-form-urlencoded';
		$this->Template->formId  = 'member_flag_toggle_button';
		$this->Template->flagId  = $this->member_flag_id;
		$this->Template->slabel = specialchars($this->member_flag_button_text);
		$this->Template->action = $this->getIndexFreeRequest();
	}
	
	/**
	 * Send an admin notification e-mail
	 * @param integer
	 * @param array
	 */
	protected function sendAdminNotification($arrData)
	{
		$objEmail = new Email();

		$objEmail->from = $GLOBALS['TL_ADMIN_EMAIL'];
		$objEmail->fromName = $GLOBALS['TL_ADMIN_NAME'];
		$objEmail->subject = sprintf($this->member_flag_mail_subject, $this->Environment->host);

		$strData = strtr($this->member_flag_mail_text, array('{name}' => $arrData['name'], '{id}' => $arrData['id'], '{flag}' => $arrData['flag'], '{state}' => $arrData['state']));

		$objEmail->text = $strData;
		$objEmail->sendTo($GLOBALS['TL_ADMIN_EMAIL']);
	}	
}