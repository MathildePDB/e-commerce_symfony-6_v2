<?php

namespace App\Controller;

use App\Repository\OrdersDetailsRepository;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(OrdersRepository $ordersRepository, OrdersDetailsRepository $ordersDetailsRepository): Response
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
        
        return $this->render('profile/index.html.twig', [
            'orders' => $orders,
            'total' => $total,
        ]);
    }

    #[Route('/commande', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'User\'s orders',
        ]);
    }
}
