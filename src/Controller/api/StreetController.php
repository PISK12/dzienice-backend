<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 18/09/2018
	 * Time: 19:52
	 */

	namespace App\Controller\api;

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	use FOS\RestBundle\View\View;

	use FOS\RestBundle\Controller\FOSRestController;
	use FOS\RestBundle\Controller\Annotations\View as ViewAnnotation;
	use FOS\RestBundle\Controller\Annotations as Rest;

	use App\Entity\Street;
	use App\Entity\District;

	use App\Service\ExtendedStreet;


	class StreetController extends FOSRestController
	{
		/**
		 * @Rest\Get("/streets/")
		 * @ViewAnnotation()
		 */
		public function getAction(){
			$extendedStreet = new ExtendedStreet();
			$rawResults=$this->getDoctrine()->getRepository(Street::class)->findAll();
			if($rawResults==null){
				return new View("there are on user exist",Response::HTTP_NOT_FOUND);
			}

			$results=[];
			foreach($rawResults as $result){
				$results[]=$extendedStreet->getAllPublicInformation($result);
			}
			//var_dump($results);
			$view = View::create()
				->setStatusCode(200)
				->setData($results);
			return $this->handleView($view);
		}

		/**
		 * @Rest\Get("/streets/{id<\d+>}")
		 * @ViewAnnotation()
		 */
		public function idAction($id){
			$extendedStreet = new ExtendedStreet();
			$results=$this->getDoctrine()->getRepository(Street::class)->find($id);
			if($results==null){
				return new View("there are on user exist",Response::HTTP_NOT_FOUND);
			}
			$result=$extendedStreet->getAllPublicInformation($results);
			$view = View::create()
				->setStatusCode(200)
				->setData($result);
			return $this->handleView($view);
		}
	}