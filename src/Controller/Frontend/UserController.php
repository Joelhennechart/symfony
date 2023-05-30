<?php

namespace App\Controller\Frontend;

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
    public function register(Request $request, UserPasswordHasherInterface $hasher): Response   //paramétre de la methode
    {   //on instancie User
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);  //type stoque des formulaire, le champ etc...
        $form->handleRequest($request);       //écouter la requéte du formulaire create form automatiquement handlerequest derriére

        if($form->isSubmitted() && $form->isValid()){      // est ce qu'il y' a des contraintes et est ce qu'elles sont respectées
            $user->setPassword(
                $hasher->hashPassword($user, $form->get('password')->getData()) // hashage du mot de passe 
            );

            $this->repo->save($user, true);     // sauvegarde l'utilisateur dans la bdd

            $this->addFlash('success', 'Vous étes bien inscrit à notre application');   //message comme quoi tous va b ien

            return $this->redirectToRoute('app.login');     //ouvre la page login
        }

        return $this->render('Frontend/User/register.html.twig', [  
            'form' => $form,
        ]);
    }
}
