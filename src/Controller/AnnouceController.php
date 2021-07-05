<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Form\AnnounceType;
use App\Repository\AnnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AnnouceController extends AbstractController
{
    /**
     * @Route("/announces", name="app_annouce_index")
     */
    public function index(AnnounceRepository $repo, Request $request, PaginatorInterface $paginator): Response
    {

        $announces = $repo->findAll();

        $announces = $paginator->paginate(
            $announces, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

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
        //dd($announce);
        return $this->render('annouce/show.html.twig',[
            
            'announce' => $announce
        ]);
    }

    /**
     * @Route("/create", name="create_annouce",methods={"GET","POST"})
     */

    public function create(Request $request,EntityManagerInterface $em): Response
    {
        $announce = new Announce();

        $form = $this->createForm(AnnounceType::class,$announce);

         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){

            $em->persist($announce); 


            $em->flush();

            $this->addFlash('notice','Insertion reussie ');

            return $this->redirectToRoute('app_annouce_index');
            

         }
        

        return $this->render('annouce/create.html.twig',[

            'form' => $form->createView()
        ]);


        

    }


    /**
     * @Route("/update/{id<[0-9]+>}", name="app_announce_update",methods={"GET","POST"})
     */

    public function update(Request $request,EntityManagerInterface $em,AnnounceRepository $repo, int $id): Response
    {
        $announce = $repo->find($id);

        $form = $this->createForm(AnnounceType::class,$announce);

         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()){

            $em->persist($announce); 


            $em->flush();

            

            return $this->redirectToRoute('app_annouce_index');

            $this->addFlash('notice','Modification reussie ');
            
         }
        
        return $this->render('annouce/update.html.twig',[

            'form' => $form->createView(),
            'announce' => $announce 
        ]);
    }



     /**
     * @Route("/announce/{id<[0-9]+>}",name="app_announce_delete",methods={"GET"})
     */

    public function delete(AnnounceRepository $repo, int $id,EntityManagerInterface $em): Response
    {
        $announce = $repo->find($id);

        $em->remove($announce);
        $em->flush();

        

        return $this->redirectToRoute('app_annouce_index');

        $this->addFlash('notice','Suppression reussie ');
            
        
    }
}
