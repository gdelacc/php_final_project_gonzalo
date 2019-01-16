<?php
namespace App\Service;


use App\Entity\Rental;
use App\Entity\Car;
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

class RentalCrudService extends CrudService implements IRentalCrudService
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
        return $this->em->getRepository(Rental::class);
    }
    /**
     * @inheritDoc
     */
    public function getAllRentals()
    {
        return $this->getRepo()->findAll();
    }
    /**
     * @inheritDoc
     */
    public function getRentalById($rentalId)
    {
        $oneRental = $this->getRepo()->find($rentalId);
        if (!$oneRental){
            throw new NotFoundHttpException("BRAND NOT FOUND");
            // controller: throw $this->createNotFoundException()
        }
        return $oneRental;
    }
   
    /**
     * @inheritDoc
     */
    public function saveRental($oneRental)
    {
        $this->em->persist($oneRental);
        $this->em->flush();
    }
    /**
     * @inheritDoc
     */
    public function deleteRental($rentalId)
    {
        $oneRental = $this->getRentalById($rentalId);
        $this->em->remove($oneRental);
        $this->em->flush();
    }
}