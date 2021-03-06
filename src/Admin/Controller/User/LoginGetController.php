<?php
/**
 * Part of Front project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Warder\Admin\Controller\User;

use Lyrasoft\Warder\Helper\UserHelper;
use Lyrasoft\Warder\Helper\WarderHelper;
use Phoenix\Controller\Display\DisplayController;

/**
 * The GetController class.
 * 
 * @since  1.0
 */
class LoginGetController extends DisplayController
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'user';

	/**
	 * prepareExecute
	 *
	 * @return  void
	 */
	protected function prepareExecute()
	{
		$return = $this->input->getBase64(
			$this->package->get('admin.login.return_key', 'return')
		);

		if (UserHelper::isLogin())
		{
			if ($return)
			{
				$this->app->redirect(base64_decode($return));
			}
			else
			{
				$this->app->redirect($this->getHomeRedirect());
			}

			return;
		}

		if ($return)
		{
			$this->setUserState($this->getContext('return'), $return);
		}

		parent::prepareExecute();
	}

	/**
	 * getHomeRedirect
	 *
	 * @return  string
	 */
	protected function getHomeRedirect()
	{
		return $this->router->route(WarderHelper::getPackage()->get('admin.redirect.login', 'home'));
	}
}
