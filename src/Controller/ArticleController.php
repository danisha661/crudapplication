<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(): Response
    {
        // $articles = ['asdfsd', 'gfdhytryy'] ; //dummy data
        // $entityManager = $this->getDoctrine()->getManager();
        // $articles = $entityManager->getRepository(Article::class)->findAll();

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll(); //get all data from db

        // return $this->render('article/index.html.twig', [
        //     'controller_name' => 'ArticleController',
        //     'username' => 'testuser' //passing stuffs into the view
        // ]);

        // dd( $articles);

        // dd($this->render('article/index.html.twig', ['articles' => $articles]) );
        return $this->render('article/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/article/new", name="new-article")
     * Method({"GET", "POST"})
     */

    public function newArticle(Request $request)
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array(
                'attr' => array("class" => "form-control"),
                'required' => false
            ))
            ->add('body', TextareaType::class, array(
                "attr" => array("class" => "form-control"),
            ))
            ->add('save', SubmitType::class, array(
                "label" => "Create",
                "attr" => array("class" => "btn btn-primary")
            ))
            ->getForm();

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

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array(
                'attr' => array("class" => "form-control"),
                'required' => false
            ))
            ->add('body', TextareaType::class, array(
                "attr" => array("class" => "form-control"),
            ))
            ->add('save', SubmitType::class, array(
                "label" => "Save Changes",
                "attr" => array("class" => "btn btn-primary")
            ))
            ->getForm();

        //get form data
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $articles = $form->getData();
            //dd($articles);
            $entityManager = $this->getDoctrine()->getManager();
            //persist data, getting ready to save
            // $entityManager->persist($articles);
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
    public function showArticle($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('showarticle.html.twig', ['singlearticle' => $article]);
    }

    // delete
    /**
     * @Route("/article/delete/{id}", name="delete-article")
     * Method({"DELETE"})
     */
    public function deleteArticle($id)
    {
        //find it by the id
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        //delete it 
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }
}
