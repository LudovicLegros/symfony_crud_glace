<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PizzaController extends AbstractController
{
    #[Route('/modifier_pizza/{id}', name: 'modify_pizza')]
    #[Route('/pizza', name: 'add_pizza')]
    public function index(?Pizza $pizza, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérification si l'objet existe via l'injection de dependance
        // Si injection de dependance = On est en Modification
        // Sinon, on est un Creation et on créé l'objet
        if(!$pizza){
            $pizza = new Pizza;
        }
        

        // Récupération du formulaire et association avec l'objet
        $form = $this->createForm(PizzaType::class,$pizza);

        // Récupération des données POST du formulaire
        $form->handleRequest($request);
        // Vérification si le formulaire est soumis et Valide
        if($form->isSubmitted() && $form->isValid()){
            // Persistance des données
            $entityManager->persist($pizza);
            // Envoi en BDD
            $entityManager->flush();

            // Redirection de l'utilisateur
            return $this->redirectToRoute('app_home');
        }

        return $this->render('pizza/addupdate.html.twig', [
            'pizzaForm' => $form->createView(), //envoie du formulaire en VUE
            'isModification' => $pizza->getId() !== null //Envoie d'un variable pour définir si on est en Modif ou Créa
        ]);
    }

    #[Route('/pizza/remove/{id}', name: 'delete_pizza')]
    public function remove(Pizza $pizza, Request $request, EntityManagerInterface $entityManager)
    {
        
        

        if($this->isCsrfTokenValid('SUP'.$pizza->getId(),$request->get('_token'))){
            $entityManager->remove($pizza);
            $entityManager->flush();
            $this->addFlash('success','La suppression à été effectuée');
            return $this->redirectToRoute('app_home');

        }
    }
}
