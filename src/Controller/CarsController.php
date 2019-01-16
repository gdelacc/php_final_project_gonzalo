<?php
/**
 * Created by PhpStorm.
 * User: gonzalo
 * Date: 14/01/2019
 * Time: 14:19
 */

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Brand;
use App\Service\ICarCrudService;
use App\Service\IBrandCrudService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CarsController extends Controller {
	/** @var ICarCrudService */
    private $carService;
    /** @var IBrandCrudService */
    private $brandService;
	
	// via the constructor: Controller as a Service
    // public function __construct($carService)
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->carService=$container->get('app.cars');
        $this->brandService=$container->get('app.brands');
    }

	/**
     * @param Request $request
     * @return JsonResponse
     * @Route(path="/save_car")
     */
    public function save_car(Request $request) : JsonResponse
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $car_id = $request->request->get("car_id");
        $car_brand = $request->request->get("car_brand");
        $car_model = $request->request->get("car_model");
        $car_price = $request->request->get("car_price");

        $car_item = $this->carService->getCarById($car_id);
        $brand_item = $this->brandService->getBrandById($car_brand);

        $car_item->setCarBrand($brand_item);
        $car_item->setCarModel($car_model);
        $car_item->setCarPrice($car_price);
        $this->carService->saveCar($car_item);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route(path="/add_new_car")
     */
    public function add_new_car(Request $request) : JsonResponse
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $car_id = $request->request->get("car_id");
		$car_brand = $request->request->get("car_brand");
        $car_model = $request->request->get("car_model");
        $car_price = $request->request->get("car_price");

        $car_item = new Car();
        $brand_item = $this->brandService->getBrandById($car_brand);

        $car_item->setCarBrand($brand_item);
        $car_item->setCarModel($car_model);
        $car_item->setCarPrice($car_price);
        $car_item->setCarVisible(1);
        $this->carService->saveCar($car_item);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route(path="/delete_car")
     */
    public function delete_car(Request $request) : JsonResponse
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $car_id = $request->request->get("car_id");
        $this->carService->deleteCar($car_id);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }
}