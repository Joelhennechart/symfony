<?php

namespace App\Controller\Frontend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainFrontendController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]   //chemin 
    public function index(): Response
    {
        $donnees = ['Pierre', 'Paul', 'Jacques'];

        return $this->render('main/index.html.twig', [ // envoie les données du controlleur a la vue
            'donnees' => $donnees,                     // données = nom de la variable qui stoque mon tableau
            'name' => 'Pierre',                          // name = nom de la variable qui stoque le mot Pierre
        ]);
    }
}
