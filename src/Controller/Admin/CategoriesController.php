<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesFormType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $perPage = 10;

        $categories = $categoriesRepository->findBy([], ['categoryOrder' => 'asc']);

        $totalCategories = count($categories);
        $totalPages = ceil($totalCategories / $perPage);

        $offset = ($page - 1) * $perPage;

        $results = array_slice($categories, $offset, $perPage);

        return $this->render('admin/categories/index.html.twig', [
            'categories' => $results,
            'currentPage' => $page,
            'pages' => $totalPages
        ]);
    }

    #[Route('/ajout', name: 'add')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PRODUCT_ADMIN');

        $category = new Categories();

        $categoryForm = $this->createForm(CategoriesFormType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $slug = $slugger->slug($category->getName());
            $category->setSlug($slug);

            $category->setCategoryOrder(0);
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès');

            return $this->redirectToRoute('admin_categories_index');
        }

        return $this->render('admin/categories/add.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Categories $category, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PRODUCT_ADMIN');

        $categoryForm = $this->createForm(CategoriesFormType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $slug = $slugger->slug($category->getName());
            $category->setSlug($slug);

            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Catégorie modifiée avec succès');

            return $this->redirectToRoute('admin_categories_index');
        }

        return $this->render('admin/categories/edit.html.twig', [
            'categoryForm' => $categoryForm->createView(),
            'category' => $category
        ]);
    }

    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Categories $category, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PRODUCT_ADMIN');

        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'Catégorie supprimée avec succès');

        return $this->redirectToRoute('admin_categories_index');
    }
}
