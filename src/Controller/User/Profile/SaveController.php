<?php
/**
 * Part of Front project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Warder\Controller\User\Profile;

use Lyrasoft\Unidev\Field\SingleImageDragField;
use Lyrasoft\Warder\Helper\AvatarUploadHelper;
use Lyrasoft\Warder\Helper\UserHelper;
use Lyrasoft\Warder\Helper\WarderHelper;
use Lyrasoft\Warder\Model\UserModel;
use Phoenix\Controller\AbstractSaveController;
use Windwalker\Core\Language\Translator;
use Windwalker\Core\Model\Exception\ValidateFailException;
use Windwalker\Core\User\User;
use Windwalker\Core\User\UserData;
use Windwalker\Data\DataInterface;
use Windwalker\Validator\Rule\EmailValidator;

/**
 * The SaveController class.
 * 
 * @since  1.0
 */
class SaveController extends AbstractSaveController
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'profile';

	/**
	 * Property itemName.
	 *
	 * @var  string
	 */
	protected $itemName = 'profile';

	/**
	 * Property listName.
	 *
	 * @var  string
	 */
	protected $listName = 'profile';

	/**
	 * Property model.
	 *
	 * @var  UserModel
	 */
	protected $model = 'user';

	/**
	 * Property useTransaction.
	 *
	 * @var  bool
	 */
	protected $useTransaction = false;

	/**
	 * Property formControl.
	 *
	 * @var  string
	 */
	protected $formControl = 'user';

	/**
	 * Property langPrefix.
	 *
	 * @var  string
	 */
	protected $langPrefix = 'warder.profile.';

	/**
	 * Property user.
	 *
	 * @var  UserData
	 */
	protected $user;

	/**
	 * prepareExecute
	 *
	 * @return  void
	 */
	protected function prepareExecute()
	{
		if (!UserHelper::isLogin())
		{
			UserHelper::goToLogin();
		}

		parent::prepareExecute();
	}

	/**
	 * preSave
	 *
	 * @param DataInterface $data
	 *
	 * @return  void
	 */
	protected function preSave(DataInterface $data)
	{
		$this->user = User::get();

		$data->id = $this->user->id;

		// Remove password so that session will not store this data
		unset($this->data['password']);
		unset($this->data['password2']);
	}

	/**
	 * postSave
	 *
	 * @param DataInterface $data
	 *
	 * @return  void
	 */
	protected function postSave(DataInterface $data)
	{
		parent::postSave($data);

		// Remove password to prevent double hash
		unset($data->password);

		// Image
		if (false !== SingleImageDragField::uploadFromController($this, 'avatar', $data, AvatarUploadHelper::getPath($data->id)))
		{
			$this->model->save($data);
		}

		// Set user data to session if is current user.
		if (User::get()->id == $data->id)
		{
			User::makeUserLoggedIn(User::get($data->id));
		}
	}

	/**
	 * validate
	 *
	 * @param  DataInterface $data
	 *
	 * @return  void
	 *
	 * @throws ValidateFailException
	 */
	protected function validate(DataInterface $data)
	{
		$validator = new EmailValidator;

		if (!$validator->validate($data->email))
		{
			throw new ValidateFailException(Translator::translate($this->langPrefix . 'message.email.invalid'));
		}

		parent::validate($data);

		$loginName = WarderHelper::getLoginName();

		if ($loginName !== 'email')
		{
			$originUser = User::get([$loginName => $data->$loginName]);

			if ($originUser->notNull() && $originUser->id !== $data->id)
			{
				throw new ValidateFailException(Translator::translate($this->langPrefix . 'message.user.account.exists'));
			}
		}

		$user = User::get(['email' => $data->email]);

		if ($user->notNull() && $user->id != $data->id)
		{
			throw new ValidateFailException(Translator::translate($this->langPrefix . 'message.user.email.exists'));
		}

		if ('' !== (string) $data->password)
		{
			if ($data->password !== $data->password2)
			{
				throw new ValidateFailException(Translator::translate($this->langPrefix . 'message.password.not.match'));
			}

			unset($data->password2);
		}
		else
		{
			unset($data->password);
		}
	}

	/**
	 * getFailRedirect
	 *
	 * @param  DataInterface $data
	 *
	 * @return  string
	 * @throws \OutOfRangeException
	 */
	protected function getFailRedirect(DataInterface $data = null)
	{
		return $this->router->route('profile_edit', $this->getRedirectQuery());
	}
}
