<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository, ActorRepository $actorRepository ): Response
    {
        return $this->render('actor/index.html.twig', [
            'actors' => $actorRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);   
    }

    #[Route('/{id}', name: 'id', methods: ['GET'])]
    public function show(Actor $actor, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        return $this->render('actor_controller_c/show.html.twig', [
            'actor' => $actor,
            'categories' => $categoryRepository->findAll(),
            'programs' => $programRepository->findAll(),
        ]);
    }

}
