<?php

namespace App\Controller\Admin;

use App\Entity\Announce;
use App\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use PhpParser\Node\Stmt\Label;

class AnnounceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Announce::class;
    }


   /* public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        
    }*/

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')->setLabel('Titre'),
            MoneyField::new('price')->setCurrency('EUR')->setLabel('Prix'),
            TextField::new('address')->setLabel('Adresse'),
            TextareaField::new('description')->onlyOnForms(),
            TextField::new('introduction')->onlyOnForms(),
            ImageField::new('coverImage')
                ->onlyOnForms()
                ->setBasePath('images/covers')
                ->setUploadDir('public/images/covers')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            BooleanField::new('isAvailable')->setLabel('Statut'),
            IntegerField::new('rooms')->setLabel('Nombre de chambres'),
            DateField::new('createdAt')->hideOnForm(),
            CollectionField::new('images')
                ->setEntryType(ImageType::class)
                ->onlyOnForms(),
            CollectionField::new('images')
                ->setEntryType(ImageType::class)
                ->setTemplatePath('images.html.twig')
                ->onlyOnDetail(), 
            AssociationField::new('user')->hideOnForm()->setLabel('Utilisateur') 
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
       return $crud
                ->setPageTitle(Crud::PAGE_INDEX, 'Liste des annonces')
                ->setDefaultSort(['createdAt' => 'DESC'])
            ; 
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->add(Crud::PAGE_INDEX,Action::DETAIL)->update(Crud::PAGE_INDEX,Action::DETAIL,function (Action $action){
                return $action->setIcon("fas fa-eye")->setLabel(false);
            })


            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->setIcon("fas fa-edit")->setLabel(false);
            
            
        })

            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {

            return $action->setIcon("fas fa-trash-alt")->setLabel(false);
            
        })
        ;

        

    }

    public function createEntity(string $entityFqcn)
    {
        $announce = new Announce();

        $announce->setUser($this->getUser());
        

        return $announce;
    }
    
}
