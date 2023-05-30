<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/users', name: 'admin.user')]        //On recupere la table user
class UserController extends AbstractController
{
    public function __construct(                    
        private readonly UserRepository $repo       // private readonly les données sont privées 
    )
    {

    }

    #[Route('', name: '.index', methods: ['GET'])]  
    public function index(): Response
    {
        return $this->render('backend/user/index.html.twig', [
            'users' => $this->repo->findAll(),
        ]);
    }
    #[Route('/{id}/edit', name: '.update', methods: ['GET', 'POST'])]
    public function update(?User $user, Request $request): Response|RedirectResponse
    {
        if (!$user instanceof User) {                   //s'il n'y a pas d'utilisateur
           $this->addFlash('error', 'User not found');
           return $this->redirectToRoute('admin.user.index');
        }
        $form =$this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $this->repo->save($user, true);

           $this->addFlash('success', 'User modify successfuly');

           return $this->redirectToRoute('admin.user.index');
        }
        return $this->render(('Backend/User/edit.html.twig'), [
            'form' => $form,
        ]);
    }
}
