<?php
namespace AppBundle\Validation\Validator;

use AppBundle\Validation\NotEmptyValidation;

class FirstNameValidator implements ValidatorInterface
{

	public function validate($param): array
	{
		$errors = [];

		$allowBlankValidation = new NotEmptyValidation(new NotEmptyValidator());
		$allowBlankValidation->isValid($param);

		$errors = $allowBlankValidation->getErrors();

		return $errors;
	}
}