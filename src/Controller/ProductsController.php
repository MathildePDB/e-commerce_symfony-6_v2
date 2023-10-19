<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductsRepository $productsRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        $products = $productsRepository->findProductsPaginated($page, null, 9);

        return $this->render('products/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/{slug}', name:'details')]
    public function details(Products $product): Response
    {
        return $this->render('products/details.html.twig', [
            'product' => $product
        ]);
    }
}
