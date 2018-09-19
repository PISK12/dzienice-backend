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
				return new View("there are on street exist",Response::HTTP_NOT_FOUND);
			}

			$results=[];
			foreach($rawResults as $result){
				$results[]=$extendedStreet->getAllPublicInformation($result);
			}
			//var_dump($results);
			$view = View::create()
				->setStatusCode(Response::HTTP_OK)
				->setData($results);
			return $this->handleView($view);
		}

		/**
		 * @Rest\Get("/streets/search/")
		 * @ViewAnnotation()
		 */
		public function searchAction(Request $request){
			$searchStreetName=$request->get("streetName");
			if(!$searchStreetName or $searchStreetName=="ulica" or $searchStreetName=="ulicy" or $searchStreetName=="ul."){
				return new View("there are on street exist",Response::HTTP_NOT_FOUND);
			}
			$rawResults=$this->getDoctrine()->getRepository(Street::class)
				->searchStreetByName($searchStreetName);
			if($rawResults==null){
				return new View("there are on street exist",Response::HTTP_NOT_FOUND);
			}
			$extendedStreet = new ExtendedStreet();
			$results=[];
			foreach($rawResults as $result){
				$results[]=$extendedStreet->getAllPublicInformation($result);
			}
			$view = View::create()
				->setStatusCode(Response::HTTP_OK)
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
				return new View("there are on street exist",Response::HTTP_NOT_FOUND);
			}
			$result=$extendedStreet->getAllPublicInformation($results);
			$view = View::create()
				->setStatusCode(Response::HTTP_OK)
				->setData($result);
			return $this->handleView($view);
		}
	}