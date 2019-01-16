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

class CarCrudService extends CrudService implements ICarCrudService
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
        return $this->em->getRepository(Car::class);
    }
    /**
     * @inheritDoc
     */
    public function getAllCars()
    {
        return $this->getRepo()->findAll();
    }
    /**
     * @inheritDoc
     */
    public function getCarsByBrand($brandId)
    {
        return $this->getRepo()->findBy(["car_brand"=>$brandId]);
    }
    /**
     * @inheritDoc
     */
    public function getCarById($carId)
    {
        $oneCar = $this->getRepo()->find($carId);
        if (!$oneCar){
            throw new NotFoundHttpException("CAR NOT FOUND");
            // controller: throw $this->createNotFoundException()
        }
        return $oneCar;
    }
    /**
     * @inheritDoc
     */
    public function getCarsByVisibility($isVisible)
    {
        // Dont use findBy IF
        // a) more complex comparison
        // b) want to do joins
        // c) return non-mapped types (e.g. brand name + car name)
        // => DQL = Doctrine Query Language

        $query = $this->em->createQuery("
            SELECT c
            FROM AppBundle:Car c
            WHERE c.car_visible = :visible
            ORDER BY c.car_price desc
        ");
        $query->setParameter("visible", $isVisible);

        $qb = $this->em->createQueryBuilder();
        $qb->select("c")
            //->select("b.brand_name, c.car_model")
            ->from("AppBundle:Car", "c")
            //->innerJoin("AppBundle:Brand", "b")
            ->where("c.car_visible = :visible")
            ->orderBy("c.car_price", "desc")
            ->setParameter("visible", $isVisible);
        $query = $qb->getQuery(); // TO READ: PAGINATION!

        return $query->getResult();

        // TO READ: EXPRESSION API
        // create COMPLEX conditions using expression trees
        // C#: Expression<Func<Entity, bool>>
    }
    /**
     * @inheritDoc
     */
    public function saveCar($oneCar)
    {
        $this->em->persist($oneCar);
        $this->em->flush();
    }
    /**
     * @inheritDoc
     */
    public function deleteCar($carId)
    {
        $oneCar = $this->getCarById($carId);
        $this->em->remove($oneCar);
        $this->em->flush();
    }
    /**
     * @inheritDoc
     */
    public function getCarForm($oneCar)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $oneCar);
        $form->add("car_visible", ChoiceType::class, [
           'choices' => array("YES"=>true, "NO"=>false )
        ]);
        $form->add("car_model", TextType::class, [
            'required'=>true
        ]);
        $form->add("car_price", NumberType::class, [
            'required'=>false
        ]);
        $form->add("car_brand", EntityType::class, [
            'class' => Brand::class,
            'choice_label'=>'brand_name',
            'choice_value'=>'brand_id'
            // query_builder
        ]);
        $form->add("SAVE", SubmitType::class);
        return $form->getForm();
    }
}