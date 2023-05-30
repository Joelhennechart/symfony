<?php

namespace App\Controller\Backend;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
