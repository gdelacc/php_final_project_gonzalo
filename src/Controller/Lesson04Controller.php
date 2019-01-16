<?php
namespace App\Controller;

use App\DTO\DTOBase;
use App\DTO\LoginDTO;
use App\DTO\TextDTO;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/editor")
 */
class Lesson04Controller extends Controller
{
    private $passFile = "../templates/editor/users.txt";
    private $dataFile = "../templates/editor/data.txt";

    /**
     * @Route("/create", name="create")
     */
    public function createPwAction(Request $request){
        $str = "";
        $str .= "bill\t".password_hash("billpass", PASSWORD_DEFAULT)."\n";
        $str .= "joe\t".password_hash("joepass", PASSWORD_DEFAULT)."\n";
        $str .= "admin\t".password_hash("adminpass", PASSWORD_DEFAULT)."\n";
        $str .= "admin2\t".password_hash("adminpass", PASSWORD_DEFAULT)."\n";
        file_put_contents($this->passFile, $str);
        return new Response(nl2br($str));
    }

    /**
     * @Route("/logout", name="editorLogout")
     */
    public function logoutAction(Request $request) {
        $this->get('session')->clear();
        $this->addFlash('notice', 'LOGGED OUT');
        return $this->redirectToRoute('editor');
    }

    /**
     * @Route("/editor", name="editor")
     */
    public function editorAction(Request $request) {
        $twigParams = array("form"=>null, "sessiontext"=>"", "filetext"=>"");
        // return $this->render("editor/editor.html.twig", $twigParams);

        $twigParams["sessiontext"] = $this->get('session')->get('text');
        if (file_exists($this->dataFile)) {
            $twigParams["filetext"] = file_get_contents($this->dataFile);
        }

        $sessionUser = $this->get('session')->get('user');

        /** @var $dto DTOBase */
        if ($sessionUser){
            $dto = new TextDTO($request, $this->get('form.factory'));
        } else {
            $dto = new LoginDTO($request, $this->get('form.factory'));
        }
        $form = $dto->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($sessionUser){
                /** @var $dto TextDTO */
                $text = $dto->getTextContent();
                if ($form->get("saveToSession")->isClicked()){
                    $this->get('session')->set('text', $text);
                    $this->addFlash("notice", "Saved to session");
                } else {
                    file_put_contents($this->dataFile, $text);
                    $this->addFlash("notice", "Saved to file");
                }
                return $this->redirectToRoute("editor");
            } else {
                /** @var $dto LoginDTO */
                $uname = $dto->getUserName();
                $upass = $dto->getUserPass();
                $file = file($this->passFile, FILE_IGNORE_NEW_LINES);
                foreach ($file as $fileLine){
                    $arr = explode("\t", $fileLine);
                    if ($uname==$arr[0] && password_verify($upass, $arr[1])){
                        $this->get('session')->set("user", $uname);
                        $this->addFlash("notice","LOGIN OK");
                        return $this->redirectToRoute("editor");
                    }
                }
                $this->addFlash("notice", "LOGIN FAIL");
                return $this->redirectToRoute("editor");
            }
        }
        $twigParams["form"]=$form->createView();
        return $this->render("editor/editor.html.twig", $twigParams);
    }
}