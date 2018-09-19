<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 19/09/2018
	 * Time: 13:18
	 */

	namespace App\Tests\Controller\api;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


	class StreetControllerTest extends WebTestCase
	{



		public function testGetAction()
		{
			$client=self::createClient();
			$client->request("GET");
			$this->assertEquals(200, $client->getResponse()->getStatusCode());

		}
	}
