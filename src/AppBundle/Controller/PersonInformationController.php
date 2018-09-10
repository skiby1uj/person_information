<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Person;
use AppBundle\Validation\FirstNameValidation;
use AppBundle\Validation\SurnameValidation;
use AppBundle\Validation\Validator\FirstNameValidator;
use AppBundle\Validation\Validator\SurnameValidator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonInformationController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 */
	public function personAction()
	{
		return $this->render("personInformation/index.html.twig", [

		]);
	}

	/**
	 * @Route("/save")
	 */
	public function personSaveAction(Request $request)
	{
		$responseMsg = 'Dane były nieprawidłowo wypełnione';

		$firstName = $request->request->get('firstname');
		$surname = $request->request->get('surname');

		$firstNameValidation = new FirstNameValidation(new FirstNameValidator());
		$isValidFirstName = $firstNameValidation->isValid($firstName);

		$surnameValidation = new SurnameValidation(new SurnameValidator());
		$isValidSurname = $surnameValidation->isValid($surname);

		if ($isValidFirstName && $isValidSurname)
		{
			$entityManager = $this->getDoctrine()->getManager();

			$person = new Person();
			$person->setFirstname($firstName);
			$person->setSurname($surname);

			$entityManager->persist($person);
			$entityManager->flush();

			$responseMsg = "Zapisano nowy rekord w bazie";
		}

		return $this->render("personInformation/index.html.twig", [
			'msg' 				=> $responseMsg,
			'errorFirstName' 	=> $firstNameValidation->getErrors(),
			'errorSurname' 		=> $surnameValidation->getErrors()

		]);
	}

	/**
	 * @Route("/get_person")
	 */
	public function getPersonAction()
	{
		$persons= $this->getDoctrine()->getRepository(Person::class)->findAll();

		return $this->render("personInformation/getPerson.html.twig", [
			'persons' => $persons
		]);
	}
}