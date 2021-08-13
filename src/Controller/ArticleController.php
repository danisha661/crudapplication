<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        // $articles = $this->getDoctrine()->getRepository(Article::class)->findAll(); //get all data from db

        $articles = $articleRepository->findAll(); //get all data from db
        return $this->render('article/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/article/new", name="new-article")
     * Method({"GET", "POST"})
     */

    public function newArticle(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        //get form data
        $form->handleRequest($request);

        // check if form submitted and is valid 
        if ($form->isSubmitted() && $form->isValid()) {
            $articles = $form->getData();
            // dd($articles);
            $entityManager = $this->getDoctrine()->getManager();
            //persist data, getting ready to save
            $entityManager->persist($articles);
            //execute to db
            $entityManager->flush();
            return $this->redirectToRoute("article");
        }

        return $this->render("newArticle.html.twig", [
            'form' => $form->createView()
        ]);
    }

    //update
    /**
     * @Route("/article/update/{id}", name="update-article")
     * Method({"GET", "POST"})
     */

    public function updateArticle(Request $request, $id)
    {
        $article = new Article();
        //find by id
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $article);

        //get form data
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //execute
            $entityManager->flush();
            return $this->redirectToRoute("article");
        }

        return $this->render("updateArticle.html.twig", [
            'form' => $form->createView()
        ]);
    }

    // view
    /**
     * @Route("/article/view/{id}", name="show-a-single-article")
     * 
     */
    public function showArticle(ArticleRepository $articleRepository, $id)
    {
        // $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $article = $articleRepository->find($id);
        return $this->render('showarticle.html.twig', ['singlearticle' => $article]);
    }

    // delete
    /**
     * @Route("/article/delete/{id}", name="delete-article")
     * Method({"DELETE"})
     */
    public function deleteArticle(ArticleRepository $articleRepository, $id)
    {
        //find it by the id
        // $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $article = $articleRepository->find($id);

        //delete it 
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
