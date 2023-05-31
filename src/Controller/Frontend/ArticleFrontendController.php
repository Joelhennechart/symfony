<?php

namespace App\Controller\Frontend;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article', name: "app.article")]
class ArticleFrontendController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $repo ) // La propiété repo n'est valable que pour cette propriete pas ces enfants car en private Pour faire les enfants il aurait fallu mettre    ){
   {} 
           
    #[Route('/liste', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('frontend/article/index.html.twig', [  //render est le chemin a ma vue
            'articles' => $this->repo->findAllWithTags(true),
        ]);
    }
}
