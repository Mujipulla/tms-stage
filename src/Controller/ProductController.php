<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Search;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/nos-produits', name: 'products')]
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->em->getRepository(Product::class)->findWithSearch($search);
        } else {
            $products = $this->em->getRepository(Product::class)->findAll();
            $this->redirectToRoute('products');
        }
        $search->string = $request->get('q', '');
        $search->categories = $request->get('categories', []);
        $search->productName = $request->get('productName', '');
        $search->categoryName = $request->get('categoryName', '');
        $products = $this->em->getRepository(Product::class)->findWithSearch($search);
        $search = $request->query->get('search');

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'search' => $search,
            'form' => $form->createView()
        ]);
    }

    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug): Response
    {
        $product = $this->em->getRepository(Product::class)->findOneBySlug($slug);
        $products = $this->em->getRepository(Product::class)->findByIsBest(1);

        if (!$product) {
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $products,
        ]);
    }

    #[Route("/cart/favorite/{id}", name: 'cart_favorite')]
    public function favorites($id, Cart $cart): Response
    {
        $cart->favorites($id); // On ajoute le produit aux favoris
        $favorites = $cart->getFavorites(); // On récupère les produits favoris
        //dd($favorites); // On affiche les produits favoris (pour vérifier)

        //return $this->redirectToRoute('cart');

        return $this->render('account/favoris.html.twig', [
            'favorites' => $favorites,
        ]);
    }

    #[Route("/cart/favorites", name: 'cart_favorites')]
    public function showFavorites(Cart $cart): Response
    {
        $favorites = $cart->getFavorites(); // On récupère les produits favoris

        return $this->render('account/favoris.html.twig', [
            'favorites' => $favorites,
        ]);
    }

}