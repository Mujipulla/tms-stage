<?php

namespace App\Classe;

use App\Entity\Product;
use App\Entity\SupportPDF;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private SessionInterface $session;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function add($id, $type = 'product'): void
    {
        $cart = $this->session->get('cart', []);
    
        if (!empty($cart[$type][$id])) {
            $cart[$type][$id]++;
        } else {
            $cart[$type][$id] = 1;
        }
        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }
    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id, $type = 'product')
    {
        $cart = $this->session->get('cart', []); 
        unset($cart[$type][$id]);
        return $this->session->set('cart', $cart); 
    }

    public function decrease($id, $type = 'product')
    {
        $cart = $this->session->get('cart', []); // Récupère le panier

        if ($cart[$type][$id] > 1) {
            $cart[$type][$id]--; // Diminue la quantité
        } else {
            unset($cart[$type][$id]); // Supprime le produit du panier
        }

        return $this->session->set('cart', $cart); // Modifier le panier
    }

    public function addSupportPDF($id): void
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart['supportPDFs'][$id])) {
            $cart['supportPDFs'][$id]++; 
        } else {

            $cart['supportPDFs'][$id] = 1;
        }
        
        $this->session->set('cart', $cart);
    }

    public function getFull(): array
    {
        $cartComplete = [];

        $cart = $this->get();

        if ($cart && is_array($cart)) { 
            foreach ($cart as $type => $items) {
                if (is_array($items)) {
                    if($type == 'supportPDFs'){
                        foreach ($items as $id => $quantity) { 
                            $item_object = $this->em->getRepository(SupportPDF::class)->findOneById($id);
                            if (!$item_object) {
                                $this->delete($id, $type);
                                continue;
                            }
                            $cartComplete[] = [
                                'item' => $item_object,
                                'quantity' => $quantity
                            ];
                        }
                    } else {
                        foreach ($items as $id => $quantity) { 
                            $item_object = $this->em->getRepository(Product::class)->findOneById($id);
                            if (!$item_object) {
                                $this->delete($id, $type);
                                continue;
                            }
                            $cartComplete[] = [
                                'item' => $item_object,
                                'quantity' => $quantity
                            ];
                        }
                    }
                }
            }
        }

        return $cartComplete;
    }

    public function getFavorites(): array
    {
        $favorites = $this->session->get('favorites', []);
        $favoriteProducts = [];

        foreach ($favorites as $id => $value) {
            $product = $this->em->getRepository(Product::class)->findOneById($id);
            if ($product) {
                $favoriteProducts[] = $product;
            }
        }

        return $favoriteProducts;
    }


    public function favorites($id) {
        // Récupère les produits favoris dans la session, sinon initialise un tableau vide
        $favorites = $this->session->get('favorites', []);

        // Ajoute le produit en favori
        $favorites[$id] = true;

        // Enregistre les produits favoris dans la session
        $this->session->set('favorites', $favorites);
    }


}