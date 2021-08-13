<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {

        //will grab everything from db
        $article = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    // /**
    //  * @Route("/article/save", name="save-article")
    //  */
    // public function saveArticle(){
    //     $entityManager = $this->getDoctrine()->getManager();
        
    //     $article = new Article("Article One", "This is a body for Article one");

    //     //tells us that we want to save it
    //     $entityManager->persist($article);

    //     //to save it 
    //     $entityManager->flush();

    //     return new Response('Save Article successfully of id: ' .$article->getId());

    // }

}
