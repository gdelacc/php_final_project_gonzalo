<?php
namespace App\Service;


use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Client;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientCrudService extends CrudService implements IClientCrudService
{
    /**
     * CarCrudService constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $request Request
     */
    public function __construct($em, $form, $request)
    {
        parent::__construct($em, $form, $request);
    }
    // ALT+INSERT => IMPLEMENT METHODS , @INHERITDOC

    /**
     * @inheritDoc
     */
    public function getRepo()
    {
        return $this->em->getRepository(Client::class);
    }
    /**
     * @inheritDoc
     */
    public function getAllClients()
    {
        return $this->getRepo()->findAll();
    }
    /**
     * @inheritDoc
     */
    public function getClientById($clientId)
    {
        $oneClient = $this->getRepo()->find($clientId);
        if (!$oneClient){
            throw new NotFoundHttpException("Client NOT FOUND");
            // controller: throw $this->createNotFoundException()
        }
        return $oneClient;
    }
   
    /**
     * @inheritDoc
     */
    public function saveClient($oneClient)
    {
        $this->em->persist($oneClient);
        $this->em->flush();
    }
    /**
     * @inheritDoc
     */
    public function deleteClient($clientId)
    {
        $oneClient = $this->getClientById($clientId);
        $this->em->remove($oneClient);
        $this->em->flush();
    }
}