<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Form\Announce1Type;
use App\Form\EditProfileType;
use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_index", methods={"GET"})
     */
    public function index(AnnounceRepository $announceRepository): Response
    {
        return $this->render('user/index.html.twig', [
            //'announces' => $announceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/annonce/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $announce = new Announce();
        $announce->setUser($user);
        $form = $this->createForm(Announce1Type::class, $announce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($announce);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'announce' => $announce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/annonce/{id}", name="user_show", methods={"GET"})
     */
    public function show(Announce $announce): Response
    {
        return $this->render('user/show.html.twig', [
            'announce' => $announce,
        ]);
    }

    /**
     * @Route("/user/annonce/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Announce $announce): Response
    {
        $form = $this->createForm(Announce1Type::class, $announce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'announce' => $announce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/annonce/delete/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, Announce $announce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$announce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($announce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }


    /**
     * @Route("/user/profile/{id}/edit", name="user_profile_edit", methods={"GET","POST"})
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class,$user );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

           $em =  $this->getDoctrine()->getManager();
           $em->persist($user);
           $em->flush();

           $this->addFlash('message','Profil mis a jour');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
