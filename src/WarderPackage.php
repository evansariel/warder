<?php
/**
 * Part of eng4tw project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Warder;

use Lyrasoft\Warder\Data\UserData;
use Lyrasoft\Warder\Helper\WarderHelper;
use Phoenix\Language\TranslatorHelper;
use Windwalker\Core\Package\AbstractPackage;

define('WARDER_ROOT', dirname(__DIR__));
define('WARDER_SOURCE', WARDER_ROOT . '/src');
define('WARDER_SOURCE_ADMIN', WARDER_SOURCE . '/Admin');
define('WARDER_TEMPLATES', WARDER_ROOT . '/templates');

/**
 * The UserPackage class.
 *
 * @since  1.0
 */
class WarderPackage extends AbstractPackage
{
	/**
	 * WarderPackage constructor.
	 */
	public function __construct()
	{
		WarderHelper::setPackage($this);
	}

	/**
	 * initialise
	 *
	 * @throws  \LogicException
	 * @return  void
	 */
	public function boot()
	{
		parent::boot();

		TranslatorHelper::loadAll($this);
	}

	/**
	 * getLoginName
	 *
	 * @param  string $default
	 *
	 * @return string
	 */
	public function getLoginName($default = 'username')
	{
		return $this->get('user.login_name', $default);
	}

	/**
	 * isFrontend
	 *
	 * @param   string $name
	 *
	 * @return  boolean
	 */
	public function isFrontend($name = null)
	{
		$package = $this->getCurrentPackage();

		if (!$package)
		{
			return false;
		}

		$name = $name ? : $package->getName();

		return in_array($name, (array) $this->get('frontend.package'));
	}

	/**
	 * isFrontend
	 *
	 * @param   string $name
	 *
	 * @return  boolean
	 */
	public function isAdmin($name = null)
	{
		$package = $this->getCurrentPackage();

		if (!$package)
		{
			return false;
		}

		$name = $name ? : $package->getName();

		return in_array($name, (array) $this->get('admin.package'));
	}

	/**
	 * isEnabled
	 *
	 * @param   string $name
	 *
	 * @return  boolean
	 */
	public function isEnabled($name = null)
	{
		return $this->isFrontend($name) || $this->isAdmin($name);
	}

	/**
	 * createUserData
	 *
	 * @param array $data
	 *
	 * @return  UserData
	 */
	public function createUserData($data = [])
	{
		$class = $this->get('class.data', 'Lyrasoft\Warder\Data\UserData');

		return new $class($data);
	}

	/**
	 * getCurrentPackage
	 *
	 * @return  AbstractPackage
	 */
	public function getCurrentPackage()
	{
		if (!$this->container->exists('current.package'))
		{
			return null;
		}

		return $this->container->get('current.package');
	}
}
