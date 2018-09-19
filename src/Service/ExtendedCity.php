<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 19/09/2018
	 * Time: 14:52
	 */

	namespace App\Service;


	class ExtendedCity
	{
		public function getAllPublicInformation($city){
			return array(
				"id"=>$city->getId(),
				"name"=>$city->getName(),
				"districts"=>$this->getDistrictsName($city),
			);
		}
		protected function getDistrictsName($city){
			$districts=[];
			$extendedDistricts=new ExtendedDistricts();
			foreach($city->getDistricts() as $district){
				$districts[$district->getName()]=$extendedDistricts->getStreetsName($district);
			}
			return $districts;
		}

	}