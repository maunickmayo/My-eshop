<?php

namespace App\Controller;

use DateTime;
use App\Entity\Produit;
use App\Form\ProduitFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/voir-les-produits", name="show_produits", methods={"GET"})
     */
    public function showProduits(EntityManagerInterface $entityManager): Response
    {
      
        return $this->render('admin/produit/show_produits.html.twig', [
            'produits' => $entityManager->getRepository(Produit::class)->findAll()
        ]);
    }
    
     /**
      * @Route("/ajouter-un-produit", name="create_produit", methods={"GET|POST"})
      */
    public function createProduit(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response 
         // un slug en web c est le fait de retirer tous les accents, d une string et tous les espaces on les remplacent par un tiret de 6 (-) et ça met tout en miniscule. c sous la forme d un objet en symfony. 
         //S.O.L.I.D
    {
        
        $produit = new Produit();

        $form = $this->createForm(ProduitFormType::class, $produit)
            ->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $produit->setCreatedAt(new DateTime());
                $produit->setUpdatedAt(new DateTime());
    
                # Récupération du fichier dans le formulaire. Ce sera un objet de type UploadedFile.
               // /** @var UploadedFile $photo */ //
                $photo = $form->get('photo')->getData();
                
                

            }

     return $this->render("admin/form/form_produit.html.twig", [
          'form' => $form->createView()
     ]);

    }



}

