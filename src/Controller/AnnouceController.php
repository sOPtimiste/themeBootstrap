<?php

namespace App\Controller;

use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/announce/create", name="create_annouce")
     */

    public function create(){

        return $this->render('annouce/create.html.twig',[]);

    }
}
