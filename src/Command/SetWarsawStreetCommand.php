<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 18/09/2018
	 * Time: 15:35
	 */

	namespace App\Command;


	use Symfony\Component\Console\Command\Command;
	use Symfony\Component\Console\Input\InputArgument;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;

	use Symfony\Component\Console\Helper\ProgressBar;

	use Doctrine\ORM\EntityManagerInterface;

	use App\Entity\City;
	use App\Entity\District;
	use App\Entity\Street;

	class SetWarsawStreetCommand extends Command
	{
		protected $em;
		protected $cacheDistrict=[];
		protected $allStreetsFromDataBase=[];
		public function __construct($name = null,EntityManagerInterface $em)
		{
			$this->em=$em;
			foreach($this->em->getRepository(Street::class)->findAll() as $adress){
				$this->allStreetsFromDataBase[]=$adress->getName();
			}
			parent::__construct($name);
		}

		protected function configure(){
			$this
				->setName('setStreet:Warszawa')
				->addArgument('fileName',InputArgument::REQUIRED);
		}

		/**
		 * @param InputInterface $input
		 * @param OutputInterface $output
		 * @return int|null|void
		 */
		protected function execute(InputInterface $input, OutputInterface $output){
			$pathFile="./var/".$input->getArgument("fileName");
			if(empty($city)){
				$city=new City();
				$city->setName("Warszawa");
				$this->em->persist($city);
				$this->em->flush();
			}



			if(file_exists($pathFile)){
				$output->write("pathFile exist\n");
			}else{
				$output->write("pathFile doesn't exist\n");
			}
			$csv = array_map('str_getcsv', file($pathFile));

			$progressBar = new ProgressBar($output, count($csv));
			$progressBar->setFormat('very_verbose');
			$progressBar->start();

			foreach ($csv as $item){
				$nameStreet=trim($item[0]);
				if(!in_array($nameStreet,$this->allStreetsFromDataBase)){

					$streetInGenitive=trim($item[1]);
					$streetShortName=trim($item[2]);

					$objectStreet=new Street();
					$objectStreet
						->setName($nameStreet)
						->setNameInGenitive($streetInGenitive)
						->setShortName($streetShortName);

					$districts=preg_split('/;/', $item[3]);
					foreach ($districts as $nameDistrict){
						$nameDistrict=trim($nameDistrict);
						if(!in_array($nameDistrict,$this->cacheDistrict)){
							$objectDistrict=$this->em
								->getRepository(District::class)
								->findOneBy(["Name"=>$nameDistrict,"City"=>$city]);
							if(empty($objectDistrict)){
								$objectDistrict = new District();
								$objectDistrict
									->setCity($city)
									->setName($nameDistrict);

								$this->em->persist($objectDistrict);
								$this->em->flush();
							}
							$this->cacheDistrict[$nameDistrict]=$objectDistrict;
						}
						$objectStreet->addDistrict($this->cacheDistrict[$nameDistrict]);
					}
					$this->em->persist($objectStreet);
					$this->em->flush();
				}
				$progressBar->advance();
			}
			$progressBar->finish();

			$output->writeln([
				"Done",
				"====\n",
			]);

		}

	}