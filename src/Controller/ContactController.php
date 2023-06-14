<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $notifier = null;
        
        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setPostedAt(new \DateTimeImmutable());
            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();
            
            
            $notifier = 'Votre message à été envoyée';

        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'notifier' => $notifier,
          
        ]);
    }
}
