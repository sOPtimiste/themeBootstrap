<?php

namespace App\Form;

use App\Entity\Announce;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class Announce1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('description',TextareaType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('price',MoneyType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('address',TextType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('coverImageFile',VichImageType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('rooms',IntegerType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('isAvailable',CheckboxType::class,[
            ])
            ->add('introduction',TextType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'label'=>false,
                'by_reference' => false,
                'disabled' => false,
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
        ]);
    }
}
