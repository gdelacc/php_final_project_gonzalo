<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/calc")
 */
class Lesson02Controller extends Controller
{
    /**
     * @Route(path="/", name="calcRootRoute" )
     * @Route(path="/form", name="calcFormRoute" )
     */
    public function CalcFormAction(Request $request) : Response
    {
        $html = file_get_contents("../templates/calc/calcform.html");
        return new Response($html);
    }

    /**
     * @Route(path="/result", name="calcResultRoute" )
     */
    public function CalcResultAction(Request $request) : Response
    {
        // GET: $request->query->get(xxx)
        $op1 = $request->request->getInt('op1');
        $op2 = $request->request->getInt('op2');
        // alternative: if (is_numeric($op1))
        $operator = $request->request->get('operator');
        if (in_array($operator, array('+', '-', '*', '/'))){
            $res = "";
            switch($operator){
                case '+': $res = $op1 + $op2; break;
                case '-': $res = $op1 - $op2; break;
                case '*': $res = $op1 * $op2; break;
                case '/':
                    if (!$op2) {
                        $res="ERROR";
                    } else {
                        $res=$op1/$op2;
                    }
                    break;
            }
            if ($res==="ERROR"){
                $output = "DIVISION BY ZERO";
            } else {
                $output = "{$op1} {$operator} {$op2} = {$res}";
            }
        } else {
            $output = "BAD OPERATOR";
        }
        $html = file_get_contents("../templates/calc/calcresult.html");
        $html = str_replace("[OUTPUT]", $output, $html);
        return new Response($html);
    }
}