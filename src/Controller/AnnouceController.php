<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Repository\AnnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnnouceController extends AbstractController
{
    /**
     * @Route("/announce", name="app_annouce")
     */
    public function index(AnnounceRepository $repo): Response
    {

        $announces = $repo->findAll();

        return $this->render('annouce/index.html.twig', [

            'announces' => $announces
           
        ]);
    }

    /**
     * @Route("/announce/{id<[0-9]+>}",name="app_announce_show",methods={"GET"})
     */

    public function show(AnnounceRepository $repo, int $id): Response
    {
        $announce = $repo->find($id);
        return $this->render('annouce/show.html.twig',[
            
            'announce' => $announce
        ]);
    }

    /**
     * @Route("/announce/create", name="create_annouce",methods={"GET","POST"})
     */

    public function create(Request $request,EntityManagerInterface $em): Response
    {
        $announce = new Announce();
        $form = $this->createFormBuilder($announce)
                        ->add('title',null) 
                        ->add('slug',null)
                        ->add('description',null)
                        ->add('price',null)
                        ->add('address',null)
                        ->add('coverImage',null,['required' => false,])
                        ->add('rooms',null)
                        ->add('isAvailable',null)
                        ->add('createdAT',null)
                        ->getForm()

         ;    
         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){

            $em->persist($announce); 


            $em->flush();

            return $this->redirectToRoute('app_annouce');
            

         }
        

        return $this->render('annouce/create.html.twig',[

            'formulaire' => $form->createView()
        ]);


        

    }
}
