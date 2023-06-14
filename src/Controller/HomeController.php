<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\User;
use App\Classe\Search;
use App\Entity\Product;
use App\Entity\Carousel;
use App\Entity\Category;
use App\Entity\SupportPDF;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request, Cart $cart): Response
    {
        //$categories = $this->em->getRepository(Category::class)->findAll();
        // Affichage des meilleurs produits
        $bestProducts = $this->em->getRepository(Product::class)->findByIsBest(4);
        $choix = $this->em->getRepository(Product::class)->findByIsChoix(1);
        $carousels = $this->em->getRepository(Carousel::class)->findAll();
        $products = $this->em->getRepository(Product::class)->findOneBy(['id' => "isChoix"]);
        $supports = $this->em->getRepository(SupportPDF::class)->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'bestProducts' => $bestProducts,
            'supports' => $supports,
            'carousels' => $carousels,
            'choix' => $choix,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, Request $request, $id): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/category/{id}', name: 'category_show')]
    public function showCategory(Request $request, Category $category): Response
    {
        $products = $this->em->getRepository(Product::class)->findBy(['category' => $category]);

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
}
