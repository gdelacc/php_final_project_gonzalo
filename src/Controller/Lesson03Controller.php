<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gb")
 */
class Lesson03Controller extends Controller
{
    private $fname = "../templates/gb/gb.txt";
    /**
     * @Route("/", name="gbIndex")
     */
    public function gbAction(Request $request)  {
        $twigParams = array("entries"=>array());
        if (file_exists($this->fname)){
            $entries = file($this->fname, FILE_IGNORE_NEW_LINES);
            $entry=array("name"=>"", "email"=>"", "text"=>"");

            foreach ($entries as $line){
                $first = substr($line, 0, 1);
                $rest = substr($line, 1);
                if ($first=="#"){
                    if ($entry["text"]) $twigParams["entries"][]=$entry;
                    $entry=array("name"=>"", "email"=>"", "text"=>"");
                    $entry["name"]=$rest;
                } else if ($first=="@"){
                    $entry["email"]=$rest;
                } else {
                    $entry["text"].=$line."\n";
                }
            }
            if ($entry["text"]) $twigParams["entries"][]=$entry;
        }
        return $this->render('gb/list.html.twig', $twigParams);
        // \xampp\php\php bin/console server:run
    }
    /**
     * @Route("/form", name="gbForm")
     */
    public function gbformAction(Request $request)  {
        return $this->render('gb/form.html.twig');

    }
    /**
     * @Route("/add", name="gbAdd")
     */
    public function gbaddAction(Request $request)  {
        $name = $request->request->get("entry_name");
        $email = $request->request->get("entry_email");
        $text = $request->request->get("entry_text");
        $text=str_replace(array("#", "@"), "", $text);
        $name=str_replace(array("\r", "\n"), "", $name);
        $email=str_replace(array("\r", "\n"), "", $email);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($name && $email && $text){
            $newentry = "#{$name}\n@{$email}\n{$text}\n";
            file_put_contents($this->fname, $newentry, FILE_APPEND);
            $this->addFlash("notice", "ENTRY SAVED");
        } else {
            $this->addFlash("notice", "DATA ERROR");
        }
        return $this->redirectToRoute('gbIndex');
    }
}