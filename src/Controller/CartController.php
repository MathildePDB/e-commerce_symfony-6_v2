<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductsRepository $productsRepository)
    {
        $panier = $session->get('panier', []);

        // on initialise des variables
        $data = [];
        $total = 0;

        // on boucle sur le panier pour récupérer les informations
        foreach ($panier as $id => $quantity) {
            $product = $productsRepository->find($id);
            $data[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
            $total += $product->getPrice() * $quantity;
        }
        
        return $this->render('/cart/index.html.twig', compact('data', 'total'));
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Products $product, SessionInterface $session, Request $request)
    {
        // on récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant s'il y en a un
        $panier = $session->get('panier', []);

        // on ajoute le produit dans la session dans le panier s'il n'y est pas encore
        // sinon on incrémente sa quantité
        if (empty($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id]++;
        }

        $session->set('panier', $panier);

        if ($request->isXmlHttpRequest()) {
            $this->addFlash('success', 'Le produit a été ajouté au panier avec succès');
        }

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Products $product, SessionInterface $session)
    {
        // on récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant s'il y en a un
        $panier = $session->get('panier', []);

        // on retire le produit dans la session dans le panier s'il n'y a qu'un exemplaire
        // sinon on décrémente sa quantité
        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);

        // on redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Products $product, SessionInterface $session)
    {
        // on récupère l'id du produit
        $id = $product->getId();

        // On récupère le panier existant s'il y en a un
        $panier = $session->get('panier', []);

        // on retire le produit dans la session dans le panier s'il n'y a qu'un exemplaire
        // sinon on décrémente sa quantité
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        // on redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }
}