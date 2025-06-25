<?php

namespace App\Controller;

use App\Form\GlaceFilterType;
use App\Repository\GlaceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(GlaceRepository $repository, Request $request): Response
    {

        $form = $this->createForm(GlaceFilterType::class);
        $form->handleRequest($request);
        $data = $form->getData();

        // dd($data); 
        if($form->isSubmitted() && $form->isValid()){  
            $glace = $repository->orderByName($data['order']);
        }else{
            $glace = $repository->findAll();
        }
        
        return $this->render('home/index.html.twig', [
            'glaces' => $glace, //Envoie de la requête en VUE 
            'form' => $form->createView(),
        ]);
    }

    #[Route('/filter', name: 'app_filter')]
    public function filter(GlaceRepository $repository, Request $request): Response
    {
        $filters = $request->query->all();
        dd($filters);
        $glaces = $repository->findByFilters($filters);

        $html = $this->renderView('partial/glace.html.twig', [
            'glaces' => $glaces,
        ]);

         // Retourne la réponse JSON
        return $this->json([
            'html' => $html,
        ]);
    }
}
