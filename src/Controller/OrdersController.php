<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\OrdersDetailsRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductsRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandes', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(OrdersRepository $ordersRepository, OrdersDetailsRepository $ordersDetailsRepository, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        
        $orders = $ordersRepository->findBy(['users' => $user], ['created_at' => 'desc']);

        $total = 0;

        $ordersDetails = $ordersDetailsRepository->findBy(['orders' => $orders]);

        foreach ($ordersDetails as $orderDetail) {
            $unitPrice = $orderDetail->getPrice();
            $quantity = $orderDetail->getQuantity();
            $total += $unitPrice * $quantity;
        }
        
        return $this->render('orders/index.html.twig', [
            'orders' => $orders,
            'total' => $total,
        ]);
    }

    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, ProductsRepository $productsRepository, EntityManagerInterface $em, SendMailService $mail): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        
        $panier = $session->get('panier', []);

        // si le panier est vide on redirige vers la page d'accueil
        if ($panier === []) {
            $this->addFlash('warning', 'Votre panier est vide');
            return $this->redirectToRoute('main');
        }

        // le panier n'est pas vide ; on crée la commande
        $order = new Orders();

        // on remplit la commande
        $order->setUsers($this->getUser());
        
        $reference = 'CMD-' . uniqid();
        $order->setReference($reference);

        // On parcourt le panier pour créer les détails de commande
        foreach ($panier as $item => $quantity) {
            $ordersDetails = new OrdersDetails();

            // on cherche le produit
            $product = $productsRepository->find($item);

            $price = $product->getPrice();
            
            // on crée le détail de commande
            $ordersDetails->setProducts($product);
            $ordersDetails->setPrice($price);
            $ordersDetails->setQuantity($quantity);

            $order->addOrdersDetail($ordersDetails);
        }

        // on persiste et on flush
        $em->persist($order);
        $em->flush();

        // on vide le panier
        $session->remove('panier');

        $mail->send(
            'no-reply@monsite.com',
            $user->getEmail(),
            'Votre commande a été enregistrée',
            'order',
            compact('user', 'order')
        );

        $this->addFlash('success', 'Votre commande a été créée avec succès');
        return $this->redirectToRoute('app_orders_index');

    }

    #[Route('/{id}', name: 'detail')]
    public function detail(OrdersRepository $ordersRepository, Orders $order, OrdersDetailsRepository $ordersDetailsRepository, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $total = 0;

        $orderDetails = $ordersDetailsRepository->findBy(['orders' => $order]);

        foreach ($orderDetails as $item) {
            $unitPrice = $item->getPrice();
            $quantity = $item->getQuantity();
            $total += $unitPrice * $quantity;
        }
        
        return $this->render('orders/details.html.twig', [
            'order' => $order,
            'orderdetails' => $orderDetails,
            'total' => $total,
        ]);
    }
}
