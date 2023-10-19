<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(
        ProductsRepository $productsRepository,
        CategoriesRepository $categoriesRepository
    ): Response
    {
        $products = $productsRepository->findBy([], ['created_at' => 'DESC'], 6);
        $categories = $categoriesRepository->findBy([], [], 6);

        return $this->render('main/index.html.twig', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
