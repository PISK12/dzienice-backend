<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 19/09/2018
	 * Time: 14:34
	 */

	namespace App\Controller\api;

	use App\Service\ExtendedCity;
	use Symfony\Component\HttpFoundation\Response;

	use FOS\RestBundle\View\View;

	use FOS\RestBundle\Controller\FOSRestController;
	use FOS\RestBundle\Controller\Annotations\View as ViewAnnotation;
	use FOS\RestBundle\Controller\Annotations as Rest;

	use App\Entity\City;



	class CityController extends FOSRestController
	{
		/**
		 * @Rest\Get("/city/")
		 * @ViewAnnotation()
		 */
		public function getAction(){
			$rawResults=$this->getDoctrine()->getRepository(City::class)->findAll();
			if($rawResults==null){
				return new View("there are on user exist",Response::HTTP_NOT_FOUND);
			}

			$results=[];
			foreach($rawResults as $result){
				$districts=[];
				foreach ($result->getDistricts() as $district){
					$districts[]=$district->getName();
				}
				$results[]=array(
					"id"=>$result->getId(),
					"name"=>$result->getName(),
					"districts"=>$districts,
				);
			}
			$view = View::create()
				->setStatusCode(Response::HTTP_OK)
				->setData($results);
			return $this->handleView($view);
		}
		/**
		 * @Rest\Get("/city/{id<\d+>}")
		 * @ViewAnnotation()
		 */
		public function idAction($id){
			$city=$this->getDoctrine()->getRepository(City::class)->find($id);
			if($city==null){
				return new View("there are on user exist",Response::HTTP_NOT_FOUND);
			}

			$extendedCity=new ExtendedCity();
			$view = View::create()
				->setStatusCode(Response::HTTP_OK)
				->setData($extendedCity->getAllPublicInformation($city));
			return $this->handleView($view);
		}
	}