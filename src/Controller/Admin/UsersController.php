<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\UsersFormType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/utilisateurs', name: 'admin_users_')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UsersRepository $usersRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $perPage = 15;

        $users = $usersRepository->findBy([], ['firstname' => 'asc']);

        $totalUsers = count($users);
        $totalPages = ceil($totalUsers / $perPage);

        $offset = ($page - 1) * $perPage;

        $results = array_slice($users, $offset, $perPage);
            
        return $this->render('admin/users/index.html.twig', [
            'users' =>$results,
            'currentPage' => $page,
            'pages' => $totalPages
        ]);

        return $this->render('admin/users/index.html.twig', compact('users'));
    }

    #[Route('/{id}', name:'details')]
    public function details(Users $user): Response
    {
        return $this->render('admin/users/details.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Users $user, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $userForm = $this->createForm(UsersFormType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Utilisateur modifié avec sucès');

            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('admin/users/edit.html.twig', [
            'userForm' => $userForm->createView(),
            'user' => $user
        ]);
    }

    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Users $user, EntityManagerInterface $em): Response
    {
        $this ->denyAccessUnlessGranted('ROLE_ADMIN');

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès');

        return $this->redirectToRoute('admin_users_index');
    }
}