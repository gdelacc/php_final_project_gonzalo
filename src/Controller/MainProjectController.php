<?php
/**
 * Created by PhpStorm.
 * User: gonzalo
 * Date: 03/12/2018
 * Time: 19:01
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
use Symfony\Component\Routing\Annotation\Route;

class MainProjectController extends  Controller
{
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
     * @Route(path="/", name="HomeIndex" )
     */
    public function Home(Request $request) : Response
    {
        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $cars = $this->carService->getAllCars();
        $brands = $this->brandService->getAllBrands();
        $twigParams = array("error"=>"", "last_username"=>"", "cars" => $cars, "brands" => $brands);
        return $this->render("project/home.html.twig", $twigParams);
    }


    /**
     * @Route(path="/project/", name="HomeProjectIndex" )
     */
    public function HomeProject(Request $request) : Response
    {

        $sessionUser = $this->get('session')->get('user');

        /** @var $dto DTOBase */
        if (!$sessionUser){
            header("Location: /login");
            die();
        }

        $str = "Welcome to the Personal Final project of Gonzalo de la Cruz";
        return new Response($str);
    }
}