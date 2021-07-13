<?php

namespace App\Form;

use App\Entity\Announce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnounceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            //->add('slug')
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
            ->add('coverImage',FileType::class,[
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => "saisir l'URL", 'class' => 'form-control'
                ]
            ])
            ->add('rooms',IntegerType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('isAvailable',CheckboxType::class)
            
            ->add('introduction',TextType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
        ]);
    }
}
