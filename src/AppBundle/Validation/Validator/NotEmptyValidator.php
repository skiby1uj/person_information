<?php
namespace AppBundle\Validation\Validator;

class NotEmptyValidator implements ValidatorInterface
{

	public function validate($param): array
	{
		$errors = [];

		if (empty($param))
			$errors[] = "Pole jest wymagane";

		return $errors;
	}
}