<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 19/09/2018
	 * Time: 15:34
	 */

	namespace App\Service;


	class ExtendedDistricts
	{
		public function getAllPublicInformation($district){
			return array(
				"id"=>$district->getId(),
				"name"=>$district->getName(),
				"city"=>$district->getCity()->getName(),
				"streets"=>$this->getStreetsName($district)
			);
		}
		public function getStreetsName($district){
			$streets=[];
			foreach ($district->getStreets() as $street){
				$streets[]=$street->getName();
			}
			return $streets;
		}
	}