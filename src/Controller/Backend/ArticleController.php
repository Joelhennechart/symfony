<?php

namespace App\Controller\Backend;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/article', name: 'admin.article')]
class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $repo  //repository n'est pas 1 article mais une instence qui permet de manipuler les articles
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return  $this->render(              //render: chemin vers le fichier de la vue (html)
            'Backend/Article/index.html.twig',
            [
                'articles' => $this->repo->findAll(),//On recupere toutes les entrées de la table article
            ]
        );
    }
    #[Route('/create', name: ".create", methods:['GET', 'POST'])]                              //#= attribut php8
    public function create(Request $request): Response|RedirectResponse
    {  
         //Création d'un nouvel objet article 
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article); //::class récupére tous le namespace et la classe de l'article
        $form->handleRequest($request);     //inspecte si le formulaire a bien était soumis

        if($form->isSubmitted() && $form->isValid()){
            //dd($article);   //=var_dump and die de $article 
            $article->setUser($this->getUser()); //setUser($this->getUser()) recupére bdans 1controleur l'utilsateur connecté
            
            $this->repo->save($article, true); //true aussi non ca ne sauvegarde pas en bdd 
            $this->addFlash('success', 'Article created successfully');
            return $this->redirectToRoute('admin.article.index');
        }

        return $this->render('Backend/Article/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/update/{id}', name: '.update', methods: ['GET', 'POST'])]
    public function update(?Article $article, Request $request): Response|RedirectResponse
    {
        if (!$article instanceof Article) {
            $this->addFlash('error', 'Article not found');

            return $this->redirectToRoute('admin.article.index');
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->save($article, true);

            $this->addFlash('success', 'Article modified successfully');

            return $this->redirectToRoute('admin.article.index');
        }

        return $this->render('Backend/Article/update.html.twig', [
            'form' => $form,
        ]);

    }

    #[Route('/delete/{id}', name: '.delete', methods: ['POST', 'DELETE'])]
    public function delete(?Article $article, Request $request): RedirectResponse
    {
        if (!$article instanceof Article) {
            $this->addFlash('error', 'Article not found');
            return $this->redirectToRoute('admin.article.index');
        }
    
    if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('token'))) {
        $this->repo->remove($article, true);

        $this->addFlash('success', 'Article deleted successfully');

        return $this->redirectToRoute('admin.article.index');
        }
        $this->addFlash('error', 'Token invalide');
        return $this->redirectToRoute('admin.article.index');
    }
    }