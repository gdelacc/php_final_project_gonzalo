<?php
/**
 * Created by PhpStorm.
 * User: gonzalo
 * Date: 14/01/2019
 * Time: 14:17
 */

namespace App\Controller;

use App\Entity\Client;
use App\Service\IClientCrudService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ClientsController extends  Controller
{
	/** @var IClientCrudService */
    private $clientService;

	// via the constructor: Controller as a Service
    // public function __construct($clientService)
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->clientService=$container->get('app.clients');
    }

    /**
     * @Route(path="/clients")
     */
    public function index(Request $request) : Response
    {
        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }
        
        $clients = $this->clientService->getAllClients();
        $twigParams = array("error"=>"", "last_username"=>"", "clients" => $clients);
        return $this->render("clients/index.html.twig", $twigParams);
    }

    /**
     * @Route(path="/save_client")
     */
    public function save_client(Request $request)
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $client_id = $request->request->get("client_id");
        $client_name = $request->request->get("client_name");
        $client_lastname = $request->request->get("client_lastname");
        $client_phone = $request->request->get("client_phone");
        $client_email = $request->request->get("client_email");

        $client_item = $this->clientService->getClientById($client_id);
        $client_item->setClientName($client_name);
        $client_item->setClientLastname($client_lastname);
        $client_item->setClientPhone($client_phone);
        $client_item->setClientEmail($client_email);
        $this->clientService->saveClient($client_item);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }

    /**
     * @Route(path="/add_new_client")
     */
    public function add_new_client(Request $request)
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

		$client_name = $request->request->get("client_name");
        $client_lastname = $request->request->get("client_lastname");
        $client_phone = $request->request->get("client_phone");
        $client_email = $request->request->get("client_email");

        $client_item = new Client();
        $client_item->setClientName($client_name);
        $client_item->setClientLastname($client_lastname);
        $client_item->setClientPhone($client_phone);
        $client_item->setClientEmail($client_email);
        $this->clientService->saveClient($client_item);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }

    /**
     * @Route(path="/delete_client")
     */
    public function delete_client(Request $request)
    {

        if ($tokenInterface = $this->get('security.token_storage')->getToken()->getUser()=="anon."){
            header('Location: /login');
            exit;
        }

        $client_id = $request->request->get("client_id");

        $this->clientService->deleteClient($client_id);

        $arrData = ['output'=>'success'];
        return new JsonResponse($arrData);

    }
}