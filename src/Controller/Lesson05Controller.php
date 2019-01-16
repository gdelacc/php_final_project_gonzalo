<?php
namespace App\Controller;


use App\DTO\TextDTO;
use App\Utils\Sql;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/votes")
 */
class Lesson05Controller extends Controller
{
    /**
     * @var Sql
     */
    private $sql;

    private function init(){
        $this->sql = new Sql("localhost", "php", "phpuser", "phppass");
    }
    /**
     * @Route("/", name="votes_listq")
     */
    public function listqAction(Request $request){
        $this->init();
        $twigParams = array("questions"=>array(), "form"=>null);
        $twigParams["questions"]=$this->sql->execMany("SELECT * FROM questions"); // SHOULD USE VIEWMODEL CLASS
        $dto = new TextDTO($request, $this->get('form.factory'));
        $form = $dto->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $sql = "INSERT INTO questions VALUES (NULL, :question)";
            $sqlParams = array("question"=>$dto->getTextContent());
            $affected = $this->sql->execNonSelect($sql, $sqlParams);
            $msg = "INSERTED {$affected} ROWS INTO QUESTIONS TABLE";
            $this->addFlash("notice", $msg);
            return $this->redirectToRoute("votes_listq");
        }
        $twigParams["form"]=$form->createView();
        return $this->render("votes/questions.html.twig", $twigParams);
    }
    /**
     * @Route("/{question}", name="votes_listc",
     *              requirements={ "question": "\d+" })
     */
    public function listcAction(Request $request, $question){
        $this->init();
        $this->sql->checkId("questions", "qu_id", $question);
        $twigParams = array("choices"=>array(), "form"=>null);
        $twigParams["choices"]=$this->sql->execMany(
            "SELECT * FROM choices WHERE cho_qu = :question",
            array("question"=>$question));
        $dto = new TextDTO($request, $this->get('form.factory'));
        $form = $dto->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $sql = "INSERT INTO choices VALUES (NULL, :question, :choice, 0)";
            $sqlParams = array("question"=>$question, "choice"=>$dto->getTextContent());
            $affected = $this->sql->execNonSelect($sql, $sqlParams);
            $msg = "INSERTED {$affected} ROWS INTO CHOICES TABLE";
            $this->addFlash("notice", $msg);
            return $this->redirectToRoute("votes_listc", array("question"=>$question));
        }
        $twigParams["form"]=$form->createView();
        return $this->render("votes/choices.html.twig", $twigParams);

    }
    /**
     * @Route("/vote/{choice}", name="votes_vote",
     *              requirements={ "choice": "\d+" })
     */
    public function voteAction(Request $request, $choice){
        $this->init();
        $this->sql->checkId("choices", "cho_id", $choice);
        $sql = "UPDATE choices SET cho_numvotes = cho_numvotes+1 WHERE cho_id = :choice";
        $sqlParam = array("choice"=>$choice);
        $affected = $this->sql->execNonSelect($sql, $sqlParam);
        $single = $this->sql->execOne("SELECT * FROM choices WHERE cho_id = :choice", $sqlParam);
        $this->addFlash("notice", "VOTED FOR {$choice}, AFFECTED: {$affected}");
        return $this->redirectToRoute("votes_listc", array("question"=>$single["cho_qu"]));
    }
    /**
     * @Route("/delq/{question}", name="votes_delq", requirements={ "question": "\d+" })
     */
    public function delqAction(Request $request, $question){
        $this->init();
        $this->sql->checkId("questions", "qu_id", $question);
        $sqlParam = array("question"=>$question);
        $sql = "DELETE FROM choices WHERE cho_qu = :question";
        $aff1 = $this->sql->execNonSelect($sql, $sqlParam);
        $sql = "DELETE FROM questions WHERE qu_id = :question";
        $aff2 = $this->sql->execNonSelect($sql, $sqlParam);
        $this->addFlash("notice", "DELETED {$aff1} AND {$aff2} ROWS");
        return $this->redirectToRoute("votes_listq");
    }
    /**
     * @Route("/delc/{choice}", name="votes_delc", requirements={ "choice": "\d+" })
     */
    public function delcAction(Request $request, $choice){
        $this->init();
        $this->sql->checkId("choices", "cho_id", $choice);
        $sqlParam = array("choice"=>$choice);
        $sql = "SELECT * FROM choices WHERE cho_id = :choice";
        $single = $this->sql->execOne($sql, $sqlParam);
        $sql = "DELETE FROM choices WHERE cho_id = :choice";
        $aff = $this->sql->execNonSelect($sql, $sqlParam);
        $this->addFlash("notice", "DELETED {$aff} CHOICE");
        return $this->redirectToRoute("votes_listc", array("question"=>$single["cho_qu"]));
    }
}