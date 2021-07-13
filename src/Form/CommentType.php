<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('author',TextType::class,[
            'attr' => [
                'placeholder' => "author", 'class' => 'form-control'
            ]
        ])
        ->add('email',EmailType::class,[
            'attr' => [
                'placeholder' => "sall@sall.com", 'class' => 'form-control'
            ]
        ])
        ->add('content',TextareaType::class,[
            'attr' => [
                'placeholder' => "content", 'class' => 'form-control'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
