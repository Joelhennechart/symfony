<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repo
    ){
        
    }
    #[Route('/register', name: 'app.user.register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hasher): Response
    {   //on instancie User
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $hasher->hashPassword($user, $form->get('password')->getData())
            );
            $this->repo->save($user, true);

            $this->addFlash('success', 'Vous étes bien inscrit à notre application');

            return $this->redirectToRoute('app.login');
        }

        return $this->render('user/index.html.twig', [
            'form' => $form,
        ]);
    }
}
