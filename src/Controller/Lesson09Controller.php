<?php
namespace App\Controller;

use App\Entity\Car;
use App\Service\ICarCrudService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

// carlist(brandId?), carshow(carId), cardel(carId)
// caredit(carId?)

class Lesson09Controller extends Controller
{
    /** @var ICarCrudService */
    private $carService;

    // via the constructor: Controller as a Service
    // public function __construct($carService)
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->carService=$container->get('app.cars');
    }

    // carlist
    // carlist/5
    // carlist?visible=1
    /**
     * @Route("/carlist/{brandId}", name="carlist")
     */
    public function listAction(Request $request, $brandId=0) {
       if ($brandId){
           $cars = $this->carService->getCarsByBrand($brandId);
       } else {
           $visible = $request->query->getInt("visible");
           if ($visible!=null){
               $cars = $this->carService->getCarsByVisibility($visible);
           } else {
               $cars = $this->carService->getAllCars();
           }
       }
       // TODO: convert service entities to DTOs/models
        $twigParams = array("cars"=>$cars);
        return $this->render('cars/carlist.html.twig', $twigParams);
    }
    /**
     * @Route("/carshow/{carId}", name="carshow")
     */
    public function showAction(Request $request, $carId) {
        $oneCar = $this->carService->getCarById($carId);
        return $this->render('cars/onecar.html.twig',
            ["car"=>$oneCar]);
    }
    /**
     * @Route("/cardel/{carId}", name="cardel")
     */
    public function delAction(Request $request, $carId) {
        $this->carService->deleteCar($carId);
        $this->addFlash('notice', 'CAR DELETED');
        return $this->redirectToRoute('carlist');
    }
    /**
     * @Route("/caredit/{carId}", name="caredit")
     */
    public function editAction(Request $request, $carId=0) {
        if ($carId){
            $oneCar = $this->carService->getCarById($carId);
        } else {
            $oneCar = new Car();
        }
        $form = $this->carService->getCarForm($oneCar);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->carService->saveCar($oneCar);
            $this->addFlash('notice', 'CAR EDITED');
            return $this->redirectToRoute('carlist');
        }
        return $this->render('cars/caredit.html.twig',
            ["form"=>$form->createView()]);
    }
}