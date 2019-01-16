<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/first")
 */
class Lesson01Controller extends Controller
{
    // FAT SERVICES, SKINNY CONTROLLERS
    private function isPrime(int $num) : bool {
        if ($num<2) return false;
        $lim = sqrt($num);
        for ($i=2; $i<=$lim; $i++){
            if ($num%$i == 0) return false;
        }
        return true;
    }
    private function getTable() : string {
        $output = ""; // All files relative to the PUBLIC directory!
        $tpl_norm=file_get_contents("../templates/prime/cellnormal.html");
        $tpl_prime=file_get_contents("../templates/prime/cellprime.html");
        $tpl_rows=file_get_contents("../templates/prime/rowsep.html");
        $tpl_table=file_get_contents("../templates/prime/table.html");

        $rows="";
        $max=0;
        for ($i=1; $i<=100; $i++){
            $num = rand(0, 999);
            if ($this->isPrime($num)) {
                $rows.=str_replace("[NUM]", $num, $tpl_prime);
            } else {
                $rows.=str_replace("[NUM]", $num, $tpl_norm);
            }
            if ($i%10==0){
                $rows.=$tpl_rows;
            }
            if ($num>$max){
                $max=$num;
            }
        }
        $output.=$tpl_table;
        $output=str_replace("[ROWS]", $rows, $output);
        $output=str_replace("[MAX]", $max, $output);
        return $output;
    }

    /**
     * @Route(path="/", name="primeRoute" )
     */
    public function PrimeRequest(Request $request) : Response
    {
        $table = $this->getTable();
        return new Response($table);

        var_dump($this->isPrime(42));
        var_dump($this->isPrime(3));
        var_dump($this->isPrime(13));
        var_dump($this->isPrime(25));
        return new Response("YOLO");
    }

    /**
     * @Route(path="/demo/{id}/{lang}", name="demoRoute", requirements={ "id": "\d+" } )
     */
    public function MyFirstRequest(Request $request, int $id, string $lang="hu") : Response
    {
        $str = "<html><body><p>Hello, symfony! - ";
        $str .= "ID = {$id} - ";
        $str .= "LANG = {$lang}</p>";
        $str.="<p id='testable'>{$id}</p></body></html>";
        return new Response($str);
    }
}