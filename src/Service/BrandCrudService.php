<?php
namespace App\Service;


use App\Entity\Brand;
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

class BrandCrudService extends CrudService implements IBrandCrudService
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
        return $this->em->getRepository(Brand::class);
    }
    /**
     * @inheritDoc
     */
    public function getAllBrands()
    {
        return $this->getRepo()->findAll();
    }
    /**
     * @inheritDoc
     */
    public function getBrandById($brandId)
    {
        $oneBrand = $this->getRepo()->find($brandId);
        if (!$oneBrand){
            throw new NotFoundHttpException("BRAND NOT FOUND");
            // controller: throw $this->createNotFoundException()
        }
        return $oneBrand;
    }
   
    /**
     * @inheritDoc
     */
    public function saveBrand($oneBrand)
    {
        $this->em->persist($oneBrand);
        $this->em->flush();
    }
    /**
     * @inheritDoc
     */
    public function deleteBrand($brandId)
    {
        $oneBrand = $this->getBrandById($brandId);
        $this->em->remove($oneBrand);
        $this->em->flush();
    }
}