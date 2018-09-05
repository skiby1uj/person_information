<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Person;
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

		if (!empty($firstName) && !empty($surname))
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
			'msg' => $responseMsg
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