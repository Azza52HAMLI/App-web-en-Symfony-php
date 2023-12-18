<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Controller\CommandeType;
use App\Repository\CommandeRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
  
    #[Route('/article/{id}/commande', name: 'ajouter_commande')]
    public function ajoutCommande(Request $request, EntityManagerInterface $em)
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_confirme');
        }

        return $this->render('commande/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/{id}/fournisseurs', name: 'article_fournisseurs')]
    public function show_four(Request $request, int $id): Response
    {
        $article = $this->ArticleRepository->find($id);

       

        $commandes = $article->getCommandes();

        $data = [];
        foreach ($commandes as $commande) {
            $data[] = [
                'fournisseur' => $commande->getFournisseur()->getNom(),
                'quantite' => $commande->getQuantite(),
                'date' => $commande->getDate()->format('d/m/Y'),
            ];
        }

        return $this->render('article/fournisseurs.html.twig', [
            'article' => $article,
            'commandes' => $data,
        ]);
    }
}