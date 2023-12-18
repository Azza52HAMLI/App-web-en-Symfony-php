<?php

namespace App\Controller;
//A ajouter


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
     #[Route('/', name: 'app_home')]
     public function index(ArticleRepository $repository): Response
     {
        //$repository = $doctrine->getRepository(Article::class);
       // $articles = $repository->findAll(); 
     $articles = $repository->findBy([],['prix' => 'DESC']);
        return $this->render('article/index.html.twig', ['articles' => $articles]);
     }

     #[Route('/article/{id<[0-9]+>}', name: 'article_show')]

     public function show(Article $article): Response
     {
        // $repository = $doctrine->getRepository(Article::class);
        // $articles = $repository->find($id); 
         return $this->render('article/show.html.twig', ['article' => $article]);
     }

    //  #[Route('/article/create', name: 'article_create')]
    //  public function create(Request $request, EntityManagerInterface $em){
    //      $article= new Article();
    //      $form = $this->createFormBuilder($article)
    //      ->add('reference')
    //      //,TextType::class,['attr'=>["placeholder"=>"référence de l'article"]])
    //      ->add('libelle')
    //      //,TextType::class,['attr'=>["placeholder"=>"libelle de l'article"]])
    //      ->add('prix')
    //     //,TextType::class,['attr'=>["placeholder"=>"prix de l'article"]])
    //     // ->add('save',SubmitType::class,['label'=>'Enregistrer'])
    //      ->getForm();
    //      $form->handleRequest($request);

    //      if($form->isSubmitted() && $form->isValid()){
    //          $em->persist($article);
    //          $em->flush();
    //      }
      
    //  //    return $this->render('article/create.html.twig', [
    //  //         'formArticle' => $form->createView()]);
        
    //     return $this->renderForm('article/create.html.twig',['formArticle'=> $form]);
    //  }

       #[Route('/article/create', name: 'app_home')]
       public function create(Request $request, EntityManagerInterface $em){
           $article= new Article();
          // $form = $this->createFormBuilder($article)
          // ->add('reference')
           //,TextType::class,['attr'=>["placeholder"=>"référence de l'article"]])
         //  ->add('libelle')
           //,TextType::class,['attr'=>["placeholder"=>"libelle de l'article"]])
          // ->add('prix')
           //,TextType::class,['attr'=>["placeholder"=>"prix de l'article"]])
          // ->add('save',SubmitType::class,['label'=>'Enregistrer'])
          // ->getForm();
          $form=$this->createForm(ArticleType::class,$article);
           $form->handleRequest($request);
       
           if($form->isSubmitted() && $form->isValid()){
               $em->persist($article);
               $em->flush();
   
               return $this->redirectToRoute('app_home');
           }
         
           //    return $this->render('article/create.html.twig', [
           //         'formArticle' => $form->createView()]);
               
          return $this->renderForm('article/create.html.twig',['formArticle'=> $form]);
       }


       
       #[Route('/article/{id<\d+>}/edit', name: 'article_edit')]
       public function edit(Request $request, EntityManagerInterface $em){
         // $article= new Article();
         //  $form = $this->createFormBuilder()
          // ->add('reference')
           //,TextType::class,['attr'=>["placeholder"=>"référence de l'article"]])
//->add('libelle')
           //,TextType::class,['attr'=>["placeholder"=>"libelle de l'article"]])
         //  ->add('prix')
           //,TextType::class,['attr'=>["placeholder"=>"prix de l'article"]])
          // ->add('save',SubmitType::class,['label'=>'Enregistrer'])
         //  ->getForm();
         $form=$this->createForm(ArticleType::class);
           $form->handleRequest($request);
       
           if($form->isSubmitted() && $form->isValid()){
//$em->persist($article);
               $em->flush();
   
               return $this->redirectToRoute('app_home');
           }
         
           //    return $this->render('article/create.html.twig', [
           //         'formArticle' => $form->createView()]);
               
          return $this->renderForm('article/edit.html.twig',['formArticle'=> $form]);
       }



       #[Route('/article/{id<\d+>}/delete', name: 'article_delete')]
       public function delete(Article $article, EntityManagerInterface $em){

        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('app_home');
       }

    }

