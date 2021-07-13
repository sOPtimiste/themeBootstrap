<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\Comment;
use App\Form\AnnounceType;
use App\Form\CommentType;
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
     * @Route("/announce/{id<[0-9]+>}",name="app_announce_show")
     */

    public function show(Announce $announce,Request $request): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class,$comment);

        $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $em = $this->getDoctrine()->getManager();
        $announce->addComment($comment);
        $em->persist($comment);

        $em->flush();

        return $this->redirectToRoute('app_announce_show',[
            
            'id' => $announce->getId()
        ]);
    }

        //$announce = $repo->find($id);
        //dd($announce);
        return $this->render('annouce/show.html.twig',[
            
            'announce' => $announce,
            'form' => $form->createView()

        ]);
    }

        
}
