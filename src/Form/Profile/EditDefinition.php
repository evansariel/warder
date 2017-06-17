<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Warder\Form\Profile;

use Lyrasoft\Warder\Helper\WarderHelper;
use Windwalker\Core\Language\Translator;
use Windwalker\Core\Package\AbstractPackage;
use Windwalker\Form\Field;
use Windwalker\Form\FieldDefinitionInterface;
use Windwalker\Form\Form;

/**
 * The EditDefinition class.
 *
 * @since  1.0
 */
class EditDefinition implements FieldDefinitionInterface
{
	/**
	 * Property package.
	 *
	 * @var  AbstractPackage
	 */
	protected $package;

	/**
	 * WarderMethod constructor.
	 *
	 * @param AbstractPackage $package
	 */
	public function __construct(AbstractPackage $package = null)
	{
		$this->package = $package ? : WarderHelper::getPackage();
	}

	/**
	 * Define the form fields.
	 *
	 * @param Form $form The Windwalker form object.
	 *
	 * @return  void
	 */
	public function define(Form $form)
	{
		$loginName = $this->package->getLoginName();

		$form->wrap('basic', null, function(Form $form) use ($loginName)
		{
			$form->add('name', new Field\TextField)
				->label(Translator::translate('warder.user.field.name'))
				->required();

			if (strtolower($loginName) !== 'email')
			{
				$form->add($loginName, new Field\TextField)
					->label(Translator::translate('warder.user.field.' . $loginName))
					->required();
			}

			$form->add('email', new Field\EmailField)
				->label(Translator::translate('warder.user.field.email'))
				->required();

			$form->add('password', new Field\PasswordField)
				->label(Translator::translate('warder.user.field.password'))
				->set('autocomplete', 'off');

			$form->add('password2', new Field\PasswordField)
				->label(Translator::translate('warder.user.field.password.confirm'))
				->set('autocomplete', 'off');
		});
	}
}
