<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Lesson10Controller extends  Controller
{
    /**
     * @Route(path="/testDemo", name="testRoute" )
     */
    public function MyFirstRequest(Request $request) : Response
    {
        $str = "<html><body><p id='testable'><em>Symfony!</em></p></body></html>";
        return new Response($str);
    }

    /**
     * @Route(path="/testDemo/{num}", name="jsonRoute" )
     */
    public function MySecondRequest(Request $request, int $num) : Response
    {
        $data = array(); // TODO: fill with service...
        for($i=0; $i<$num; $i++) $data[]=array("name"=>"Bill {$i}", "bonus"=>rand(100,999));
        return new JsonResponse($data);
    }

}