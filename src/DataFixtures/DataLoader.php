<?php
namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Client;
use App\Entity\Rental;
use App\Entity\Repair;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DataLoader extends Fixture implements  FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;
    /** @var EntityManager */
    private $em;
    /** @var string */
    private $environment;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $kernel = $this->container->get('kernel');
        if ($kernel) $this->environment=$kernel->getEnvironment();
    }

    public function load(ObjectManager $manager)
    {
        $this->em = $manager;

        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        $stackLogger = new DebugStack();
        $echoLogger = new EchoSQLLogger();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($stackLogger);

        $bmw = new Brand();
        $bmw->setBrandName("BMW");
        $bmw->setBrandYear(1895);
        $this->em->persist($bmw);

        $audi = new Brand();
        $audi->setBrandName("AUDI");
        $audi->setBrandYear(1928);
        $this->em->persist($audi);

        $citroen = new Brand();
        $citroen->setBrandName("CITROEN");
        $citroen->setBrandYear(1965);
        $this->em->persist($citroen);

        $car1 = new Car();
        $car1->setCarBrand($bmw);
        $car1->setCarModel("116i");
        $car1->setCarVisible(true);
        $car1->setCarPrice(12345);
        $this->em->persist($car1);

        $car2 = new Car();
        $car2->setCarBrand($audi);
        $car2->setCarModel("A3");
        $car2->setCarPrice(28000);
        $car2->setCarVisible(true);
        $this->em->persist($car2);

        $client1 = new Client();
        $client1->setClientEmail("client1@clients.com");
        $client1->setClientName("Anna");
        $client1->setClientLastname("Clarkson");
        $client1->setClientPhone("+44 3456 677 56");
        $client1->setClientCreated(new \DateTime('2017-08-15'));
        $this->em->persist($client1);

        $client2 = new Client();
        $client2->setClientEmail("client2@clients.com");
        $client2->setClientName("Petter");
        $client2->setClientLastname("Labour");
        $client2->setClientPhone("+33 644 177 346");
        $client2->setClientCreated(new \DateTime('2019-01-01'));
        $this->em->persist($client2);

        $repair = new Repair();
        $repair->setCar($car1);
        $repair->setCost(2500);
        $repair->setDescription("Brakes change!");
        $repair->setReparationDate(new \DateTime('2018-07-19'));
        $this->em->persist($repair);


        $rental = new Rental();
        $rental->setCar($car1);
        $rental->setClient($client2);
        $rental->setStartDate(new \DateTime('2018-07-20'));
        $rental->setEndDate(new \DateTime('2018-07-28'));
        $rental->setRentalPrice(250);
        $this->em->persist($rental);


        $rental2 = new Rental();
        $rental2->setCar($car2);
        $rental2->setClient($client1);
        $rental2->setStartDate(new \DateTime('2017-07-19'));
        $rental2->setEndDate(new \DateTime('2018-07-22'));
        $rental2->setRentalPrice(380);
        $this->em->persist($rental2);


        echo "\nDATA INSERTION OK. QUERIES: ".count($stackLogger->queries);
        echo "\n\n";
        $this->em->flush();

        /*$oneCar = $this->em->getRepository(Car::class)->findOneBy(['car_model'=>"116i"]);
        $oneCarId = $oneCar->getCarId();
        $oneCar->setCarPrice(22222); // PROXY CLASS!!!!
        $this->em->persist($oneCar);
        $this->em->flush();
        echo "\nMOD OK. QUERIES: ".count($stackLogger->queries);
        echo "\nPRICE IS: ".$this->em->getRepository(Car::class)->find($oneCarId)->getCarPrice();
        echo "\n\n";

        echo "NUMBER OF CARS FOR BMW\n";
        $bmwId = $bmw->getBrandId();
        echo $bmw->getBrandCars()->count()."\n";
        echo $this->em->getRepository(Brand::class)->find($bmwId)->getBrandCars()->count()."\n";
        $this->em->clear();
        echo $this->em->getRepository(Brand::class)->find($bmwId)->getBrandCars()->count()."\n";
        $audi = $this->em->getRepository(Brand::class)->find($bmwId+1);
        $this->em->remove($audi);
        $this->em->flush();
        echo "\nDEL OK. QUERIES: ".count($stackLogger->queries);*/

        // CRUD = Create, Read, Update, Delete
        // TODO: CRUD SERVICE
        // Fat services, Skinny controllers
                /*
        \xampp\php\php bin/console doctrine:schema:drop --force --full-database
        \xampp\php\php bin/console doctrine:database:create
        \xampp\php\php bin/console doctrine:schema:update --force
        \xampp\php\php bin/console doctrine:fixtures:load --no-interaction -vvv
         */
    }

}