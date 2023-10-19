<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/{slug}', name: 'list')]
    public function list(
        Categories $category, 
        ProductsRepository $productsRepository, 
        Request $request
    ): Response
    {
        $page = $request->query->getInt('page', 1);

        $products = $productsRepository->findProductsPaginated($page, $category->getSlug(), 9);

        return $this->render('categories/list.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
