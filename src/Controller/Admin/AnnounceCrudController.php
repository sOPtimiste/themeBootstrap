<?php

namespace App\Controller\Admin;

use App\Entity\Announce;
use App\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class AnnounceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Announce::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('address'),
            TextareaField::new('description')->onlyOnForms(),
            TextField::new('introduction')->onlyOnForms(),
            ImageField::new('coverImage')
                ->onlyOnForms()
                ->setBasePath('images/covers')
                ->setUploadDir('public/images/covers')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            BooleanField::new('isAvailable'),
            IntegerField::new('rooms'),
            DateField::new('createdAt')->hideOnForm(),
            CollectionField::new('images')
                ->setEntryType(ImageType::class)
                ->onlyOnForms(),
            CollectionField::new('images')
                ->setEntryType(ImageType::class)
                ->setTemplatePath('images.html.twig')
                ->onlyOnDetail()  
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
       return $crud
                ->setDefaultSort(['createdAt' => 'DESC']); 
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->add(Crud::PAGE_INDEX,Action::DETAIL)->update(Crud::PAGE_INDEX,Action::DETAIL,function (Action $action){
                return $action->setIcon("fas fa-info-circle")->setLabel(false);
            })


            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->setIcon("fas fa-edit")->setLabel(false);
            
            
        })

            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {

            return $action->setIcon("fas fa-trash-alt")->setLabel(false);
            
        })
        ->setPermission(Action::EDIT, 'ROLE_ADMIN')
        ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ;

        

    }
    
}
