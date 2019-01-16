<?php
/**
 * Created by PhpStorm.
 * User: gonzalo
 * Date: 14/01/2019
 * Time: 14:19
 */

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Client;
use App\Entity\Brand;
use App\Entity\Rental;
use \DateTime;
use App\Service\ICarCrudService;
use App\Service\IClientCrudService;
use App\Service\IRentalCrudService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RentalsController extends  Controller
{
	/** @var ICarCrudService */
    private $carService;
	/** @var IClientCrudService */
    private $clientService;
	/** @var IRentalCrudService */
    private $rentalService;
	
	// via the constructor: Controller as a Service
    // public function __construct($rentalService)
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->carService=$container->get('app.cars');
        $this->clientService=$container->get('app.clients');
        $this->rentalService=$container->get('app.rentals');
    }

    /**
     * @Route(path="/rentals", name="index" )
     */
    public function index(Request $request) : Response
    {
        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }
        
        $rentals = $this->rentalService->getAllRentals();
        $clients = $this->clientService->getAllClients();
        $cars = $this->carService->getAllCars();
        $twigParams = array("error"=>"", "last_username"=>"", "rentals" => $rentals, "clients" => $clients, "cars" => $cars);
        return $this->render("rentals/index.html.twig", $twigParams);
    }

    /**
     * @Route(path="/save_rental")
     */
    public function save_rental(Request $request)
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $rental_id = $request->request->get("rental_id");
        $rental_clientid = $request->request->get("rental_clientid");
        $rental_carid = $request->request->get("rental_carid");
        $rental_price = $request->request->get("rental_price");
		$rental_start_date = DateTime::createFromFormat('Y-m-d', $request->request->get("rental_start_date"));
        $rental_end_date = DateTime::createFromFormat('Y-m-d', $request->request->get("rental_end_date"));

        $rental_item = $this->rentalService->getRentalById($rental_id);
        $client_item = $this->clientService->getClientById($rental_clientid);
	    $car_item = $this->carService->getCarById($rental_carid);

        $rental_item->setClient($client_item);
        $rental_item->setCar($car_item);
        $rental_item->setStartDate($rental_start_date);
        $rental_item->setEndDate($rental_end_date);
        $rental_item->setRentalPrice($rental_price);
        $this->rentalService->saveRental($rental_item);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }

    /**
     * @Route(path="/add_new_rental")
     */
    public function add_new_rental(Request $request)
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $rental_clientid = $request->request->get("rental_clientid");
        $rental_carid = $request->request->get("rental_carid");
        $rental_price = $request->request->get("rental_price");
		$rental_start_date = DateTime::createFromFormat('Y-m-d', $request->request->get("rental_start_date"));
        $rental_end_date = DateTime::createFromFormat('Y-m-d', $request->request->get("rental_end_date"));

        $rental_item = new Rental();
        $client_item = $this->clientService->getClientById($rental_clientid);
	    $car_item = $this->carService->getCarById($rental_carid);

        $rental_item->setClient($client_item);
        $rental_item->setCar($car_item);
        $rental_item->setStartDate($rental_start_date);
        $rental_item->setEndDate($rental_end_date);
        $rental_item->setRentalPrice($rental_price);
        $this->rentalService->saveRental($rental_item);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }

    /**
     * @Route(path="/delete_rental")
     */
    public function delete_rental(Request $request)
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $rental_id = $request->request->get("rental_id");
        $this->rentalService->deleteRental($rental_id);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }
}