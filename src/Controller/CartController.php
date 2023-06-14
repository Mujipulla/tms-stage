<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use App\Entity\SupportPDF;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $cart;
    private SessionInterface $session;
    private $em;

    /**
     * Ajouter le service SessionInterface dans le fichier services.yaml
     * configurer "Symfony\Component\HttpFoundation\Session\SessionInterface"
     * dans les services pour permettre son injection de dépendance automatique :
     *
     * Services.yaml
     *    Symfony\Component\HttpFoundation\Session\SessionInterface:
     *    class: Symfony\Component\HttpFoundation\Session\Session
     *    public: true
     */
    public function __construct(EntityManagerInterface $em, Cart $cart, SessionInterface $session)
    {
        $this->cart = $cart;
        $this->session = $session;
        $this->em = $em;
    }

    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {

        // On affiche les meilleurs produits
        $products = $this->em->getRepository(Product::class)->findOneBy(['isBest' => 1]);
        $supports = $this->em->getRepository(SupportPDF::class)->findAll();

        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull(),
            'products' => $products,
            'supports' => $supports,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, Request $request, $id): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('products');

    }

    #[Route('/cart/delete{id}', name: 'delete_to_cart')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/decrease{id}', name: 'decrease_to_cart')]
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    }

    #[Route("/account/favorite/", name: 'cart_favorite')]
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
