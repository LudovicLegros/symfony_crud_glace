<?php

namespace App\Controller;

use App\Entity\Glace;
use App\Form\GlaceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GlaceController extends AbstractController
{
    #[Route('/modifier_glace/{id}', name: 'modify_glace')]
    #[Route('/glace', name: 'add_glace')]
    public function index(?Glace $glace, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérification si l'objet existe via l'injection de dependance
        // Si injection de dependance = On est en Modification
        // Sinon, on est un Creation et on créé l'objet
        if(!$glace){
            $glace = new Glace;
        }
        

        // Récupération du formulaire et association avec l'objet
        $form = $this->createForm(GlaceType::class,$glace);

        // Récupération des données POST du formulaire
        $form->handleRequest($request);
        // Vérification si le formulaire est soumis et Valide
        if($form->isSubmitted() && $form->isValid()){
            // Persistance des données
            $entityManager->persist($glace);
            // Envoi en BDD
            $entityManager->flush();

            // Redirection de l'utilisateur
            return $this->redirectToRoute('app_home');
        }

        return $this->render('glace/addupdate.html.twig', [
            'glaceForm' => $form->createView(), //envoie du formulaire en VUE
            'isModification' => $glace->getId() !== null //Envoie d'un variable pour définir si on est en Modif ou Créa
        ]);
    }

    #[Route('/glace/remove/{id}', name: 'delete_glace')]
    public function remove(Glace $glace, Request $request, EntityManagerInterface $entityManager)
    {
        
        

        if($this->isCsrfTokenValid('SUP'.$glace->getId(),$request->get('_token'))){
            $entityManager->remove($glace);
            $entityManager->flush();
            $this->addFlash('success','La suppression à été effectuée');
            return $this->redirectToRoute('app_home');

        }
    }
}
