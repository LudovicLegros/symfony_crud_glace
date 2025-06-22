<?php

namespace App\Controller;

use App\Form\PizzaFilterType;
use App\Repository\PizzaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PizzaRepository $repository, Request $request): Response
    {

        $form = $this->createForm(PizzaFilterType::class);
        $form->handleRequest($request);
        $data = $form->getData();

        // dd($data); 
        if($form->isSubmitted() && $form->isValid()){  
            $pizza = $repository->orderByName($data['order']);
        }else{
            $pizza = $repository->findAll();
        }
        
        return $this->render('home/index.html.twig', [
            'pizzas' => $pizza, //Envoie de la requête en VUE 
            'form' => $form->createView(),
        ]);
    }

    #[Route('/filter', name: 'app_filter')]
    public function filter(PizzaRepository $repository, Request $request): Response
    {
        $filters = $request->query->all();
        dd($filters);
        $pizzas = $repository->findByFilters($filters);

        $html = $this->renderView('partial/pizza.html.twig', [
            'pizzas' => $pizzas,
        ]);

         // Retourne la réponse JSON
        return $this->json([
            'html' => $html,
        ]);
    }
}
