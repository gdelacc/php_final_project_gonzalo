<?php
namespace App\Tests;

use App\Entity\Brand;
use App\Entity\Car;
use App\Kernel;
use App\Service\ICarCrudService;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CarServiceTest extends TestCase
{
    public function testTrue(){
        $this->assertEquals(true, true);
    }

    /** @var Kernel */
    protected static $application;

    /**
     * @var EntityManager
     */
    protected static $em;

    /**
     * @var ContainerInterface
     */
    protected static $container;

    /**
     * @var ICarCrudService
     */
    protected static $service;

    /**
     * @var Brand
     */
    protected static $bmw;

    protected static function getApplication()
    {
        if (self::$application === null) {
            $kernel = new Kernel('test', true);
            $kernel->boot();
            self::$application = new Application($kernel);
            self::$application->setAutoExit(false);
            self::$container = $kernel->getContainer();
            self::$em = self::$container->get('doctrine.orm.entity_manager');

            self::$service = self::$container->get('app.cars');

            // $formFactory = self::$container->get('form.factory');
            // $request = self::$container->get('request_stack')->getCurrentRequest();
            // self::$service = new CarCrudService(self::$em, $formFactory,  $request);
            // $mock = $this->createMock(EntityManager::class);
            // custom repository
        }
        return self::$application;
    }

    protected static function runCommand($cmd){
        self::getApplication()->run(new StringInput($cmd));
    }

    protected function setUp()
    { // phpunit.xml.dist
        self::runCommand('doctrine:database:drop --force -q');
        self::runCommand('doctrine:database:create -q');
        self::runCommand('doctrine:schema:update --force -q');
        self::runCommand('doctrine:fixtures:load --no-interaction -q');

        self::$bmw = self::$em->getRepository(Brand::class)->findOneBy(['brand_name'=>'BMW']);
    }

    public function testMustExist(){
        $this->assertNotNull(self::$bmw);
        self::assertNotNull(self::$bmw);
    }

    public function testGetAll(){
        $choices = self::$service->getAllCars();
        self::assertEquals(1, count($choices));
    }

    private function createCar(){
        $car = new Car();
        $car->setCarBrand(self::$bmw);
        $car->setCarModel("Z4");
        $car->setCarPrice(123456);
        $car->setCarVisible(true);
        return $car;
    }

    public function testAdd(){
        $oneCar = $this->createCar();
        self::$service->saveCar($oneCar);

        $allCars = self::$service->getAllCars();
        self::assertEquals(2, count($allCars));
        $carFromDb = self::$em->getRepository(Car::class)->findOneBy(array('car_model'=>'Z4'));
        self::assertNotNull($carFromDb);
        return $oneCar;
    }

    /**
     * @depends testAdd
     */
    public function testAddAndRemove(){
        $oneCar = $this->testAdd();
        self::$service->deleteCar($oneCar->getCarId());

        $allCars = self::$service->getAllCars();
        self::assertEquals(1, count($allCars));
        $choiceFromDb = self::$em->getRepository(Car::class)->findOneBy(array('car_model'=>'Z4'));
        self::assertNull($choiceFromDb);
    }
}