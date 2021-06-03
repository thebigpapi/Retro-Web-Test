<?php 

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Type\ChipAliasType;
use App\Form\Type\ChipImageType;
use App\Entity\Manufacturer;
use App\Repository\ManufacturerRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;

class ChipType extends AbstractType
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getManufacturerRepository(): ManufacturerRepository
    {
        return $this->entityManager->getRepository(Manufacturer::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $chipManufacturers = $this->getManufacturerRepository()
        ->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));

        $builder
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'choices' => $chipManufacturers,
            ])
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('partNumber', TextType::class, [
                'required' => false,
            ])
            ->add('chipAliases', CollectionType::class, [
                'entry_type' => ChipAliasType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ChipImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }
}