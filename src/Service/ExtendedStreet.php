<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 18/09/2018
	 * Time: 23:13
	 */

	namespace App\Service;


	class ExtendedStreet
	{
		public function getAllPublicInformation($street){
			return array(
				"id"=>$street->getId(),
				"name"=>$street->getName(),
				"nameInGenitive"=>$street->getNameInGenitive(),
				"shortName"=>$street->getShortName(),
				"districts"=>$this->getDistrictsName($street),
				"city"=>$this->getCityName($street),
			);
		}

		protected function getCityName($street){
			$results=[];
			foreach ($street->getDistricts()as $district){
				$city=$district->getCity()->getName();
				if(!in_array($city,$results)){
					$results[]=$city;
				}
			}
			return $results;
		}

		protected function getDistrictsName($street){
			$results=[];
			foreach ($street->getDistricts()as $district){
				$results[]=$district->getName();
			}
			return $results;
		}

	}