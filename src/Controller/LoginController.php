<?php
// TODO:      * @Route("/logout", name="editorLogout")

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends  Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route(path="/login", name="login")
     */
    public function loginAction(Request $request) : Response
    {
        $twigParams = array("error"=>"", "last_username"=>"");
        $authUtils = $this->get("security.authentication_utils");
        $twigParams["error"]=$authUtils->getLastAuthenticationError();
        $twigParams["last_username"]=$authUtils->getLastUsername();

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()!="anon."){
            header('Location: /');
            exit;
        }

        return $this->render("login.html.twig", $twigParams);
    }
    /**
     * @param Request $request
     * @return Response
     * @Route(path="/logout", name="logout")
     */
    public function logoutAction(Request $request) : Response
    {
    }
    /**
     * @param Request $request
     * @return Response
     * @Route(path="/register", name="register")
     */
    public function registerAction(Request $request) : Response
    {
        // TODO: DTO ... Service ...
        $user = new User();
        $uname = $request->request->get("_username");
        $clearpass = $request->request->get("_password");
        $hashpass = $this->get("security.password_encoder")->encodePassword($user, $clearpass);
        $user->setUserEmail($uname);
        $user->setUserPass($hashpass);
        $user->setUserRank("ADMIN");
        try {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("notice", "USER {$uname} REGISTERED");
        }
        catch (\Exception $ex){
            $this->addFlash("notice", "ERROR {$ex->getMessage()}");
        }
        return $this->redirectToRoute("login");
    }
    //\xampp\php\php bin/console debug:route
    //\xampp\php\php bin/console server:run
    // http://localhost:8000/login

    /**
     * @param Request $request
     * @return Response
     * @Route(path="/secure", name="secureContent")
     * xxx@Security("has_role('ROLE_ADMIN')")
     */
    public function secureAction(Request $request) : Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        /*
        $authChecker = $this->get("security.authorization_checker");
        if (!$authChecker->isGranted("ROLE_ADMIN")){
            throw $this->createAccessDeniedException();
        }
        */

        return new Response("Secure content, Wololo!");
    }


}