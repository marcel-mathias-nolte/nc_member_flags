<?php 

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
 * Run in a custom namespace, so the class can be replaced
 */
namespace NC;

/**
 * Class NcMemberFlagToggleHandler
 *
 * Provide hook callbacks for content, page, article and module filtering.
 */
class NcMemberFlagToggleHandler extends \Backend
{

	/**
     * This is called before a content element is rendered on the frontend.
     * @param $objElement
     * @param $strBuffer
     * @return string
     */
    public function gateKeeperContent($objElement, $strBuffer) 
	{
        if (TL_MODE == 'BE') 
		{
            return $strBuffer;
        }
        if ($objElement->depend_on_member_flag) 
		{
			if (!FE_USER_LOGGED_IN)
			{
				return '';
			}
			$this->import('FrontendUser', 'User');
			$flags = $this->User->member_flags;
			if (
				$objElement->depend_on_member_flag_state > 0 && 
				(
					!is_array($flags) || 
					!isset($flags[$objElement->member_flag_id]) || 
					(!$flags[$objElement->member_flag_id] && $objElement->depend_on_member_flag_state == 1) ||  
					($flags[$objElement->member_flag_id] && $objElement->depend_on_member_flag_state == 2)
				)
			)
			{
	            return '';
			}
        }
        return $strBuffer;
    }

	/**
     * This is called before a module element is rendered on the frontend.
     * @param $objElement
     * @param $strBuffer
     * @return string
     */
    public function gateKeeperModule($objModule, $strBuffer) 
	{
        if (TL_MODE == 'BE') 
		{
            return $strBuffer;
        }
        if ($objModule->depend_on_member_flag) 
		{
			if (!FE_USER_LOGGED_IN)
			{
				return '';
			}
			$this->import('FrontendUser', 'User');
			$flags = $this->User->member_flags;
			if (
				$objModule->depend_on_member_flag_state > 0 && 
				(
					!is_array($flags) || 
					!isset($flags[$objModule->member_flag_id]) || 
					(!$flags[$objModule->member_flag_id] && $objModule->depend_on_member_flag_state == 1) ||  
					($flags[$objModule->member_flag_id] && $objModule->depend_on_member_flag_state == 2)
				)
			)
			{
	            return '';
			}
        }
        return $strBuffer;
    }

    /**
     * This is called before a article is rendered on the frontpage.
     * @param $objArticle
     * @return mixed
     */
    public function gateKeeperArticle($objArticle) 
	{
        if (TL_MODE == 'BE') 
		{
            return;
        }
        if ($objArticle->depend_on_member_flag) 
		{
			if (!FE_USER_LOGGED_IN)
			{
				$objArticle->published = FALSE;
			}
			$this->import('FrontendUser', 'User');
			$flags = $this->User->member_flags;
			if (
				$objArticle->depend_on_member_flag_state > 0 && 
				(
					!is_array($flags) || 
					!isset($flags[$objArticle->member_flag_id]) || 
					(!$flags[$objArticle->member_flag_id] && $objArticle->depend_on_member_flag_state == 1) ||  
					($flags[$objArticle->member_flag_id] && $objArticle->depend_on_member_flag_state == 2)
				)
			)
			{
	            $objArticle->published = FALSE;
			}
        }
    }

    /**
     * This is called before a menu gets rendered and will remove page entities which should be hidden.
     * @param $obj
     */
    public function gateKeeperPage($obj) 
	{
        $new = array();
		$flags = false;
		if (FE_USER_LOGGED_IN)
		{
			$this->import('FrontendUser', 'User');
			$flags = $this->User->member_flags;
		}
        if (is_array($obj->items)) 
		{
            for($k = 0; $k < count($obj->items); $k++)
			{
                if (
					$obj->items[$k]->depend_on_member_flag_state > 0 && 
					(
						!is_array($flags) || 
						!isset($flags[$obj->items[$k]->member_flag_id]) || 
						(!$flags[$obj->items[$k]->member_flag_id] && $obj->items[$k]->depend_on_member_flag_state == 1) ||  
						($flags[$obj->items[$k]->member_flag_id] && $obj->items[$k]->depend_on_member_flag_state == 2)
					)
				)
				{
                    continue;
                }
                $new[] = $obj->items[$k];
            }
            $obj->items = $new;
        }
    }
}

?>