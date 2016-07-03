<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Lyrasoft\Warder\Admin\Form\Users;

use Windwalker\Form\Field\ListField;
use Windwalker\Form\Field\TextField;
use Windwalker\Form\FieldDefinitionInterface;
use Windwalker\Form\Form;
use Windwalker\Html\Option;

/**
 * The UsersFilterDefinition class.
 *
 * @since  {DEPLOY_VERSION}
 */
class BatchDefinition implements FieldDefinitionInterface
{
	/**
	 * Define the form fields.
	 *
	 * @param Form $form The Windwalker form object.
	 *
	 * @return  void
	 */
	public function define(Form $form)
	{
		/*
		 * This is batch form definition.
		 * -----------------------------------------------
		 * Every field is a table column.
		 * For example, you can add a 'category_id' field to update item category.
		 */
		$form->wrap(null, 'batch', function (Form $form)
		{
			// Language
			$form->list('language')
				->label('Language')
				->set('class', 'col-md-12')
				->option('-- Select Language --', '')
				->option('English', 'en-GB')
				->option('Chinese Traditional', 'zh-TW');

			// Author
			$form->text('created_by')
				->label('Author');
		});
	}
}
