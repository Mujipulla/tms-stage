<?php

namespace App\Controller;

use App\Entity\About;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{  
     private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        $about = $this->em->getRepository(About::class)->findAll();

        return $this->render('about/index.html.twig', [
            'about' => $about,
        ]);
    }
}
