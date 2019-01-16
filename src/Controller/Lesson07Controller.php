<?php
namespace App\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seventh")
 */
class Lesson07Controller extends Controller
{
    /**
     * @Route(path="/", name="seventhRoute" )
     */
    public function PrimeRequest(Request $request) : Response
    {
        $carService = $this->get('app.cars');
        $cars = $carService->getAllCars();
        // NEVER USE VAR_DUMP WITH ENTITIES!
        Debug::dump($cars); // deprecated, use symfony/var-dumper instead
        $oneCar = $carService->getCarById($cars[0]->getCarId());
        Debug::dump($oneCar->getCarBrand());
        die();
    }
}