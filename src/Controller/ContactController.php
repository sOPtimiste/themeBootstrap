<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private $flash;
    public function __construct(FlashBagInterface $flash)
    {
        $this->flash = $flash;
        
    }
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class,$contact);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);

                $em->flush();

                return $this->redirectToRoute('app_contact');

                $this->flash->add('success', 'votre message a bien envoyé,merci !!');

            }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
