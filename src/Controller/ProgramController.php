<?php

namespace App\Controller;


use App\Entity\Program;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $programs = $programRepository->findAll();

        $categories = $categoryRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
            'categories' => $categories,
        ]);
    }

    #[Route('/list/{categoryId}', requirements: ['categoryId' => '^[0-9]+$'], methods: ['GET'], name: 'list')]
    public function list(int $categoryId, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $programs = $programRepository->findBy(['category' => $categoryId]);

        if (!$programs)
            throw $this->createNotFoundException('Aucune série trouvée');

            $categories = $categoryRepository->findAll();

        return $this->render('program/list.html.twig', [
            'programs' => $programs,
            'categories' => $categories,
        ]);
    }


    #[Route('/{id}', requirements: ['id' => '^[0-9]+$'], methods: ['GET'], name: 'show')]
    public function show(Program $program,  CategoryRepository $categoryRepository): Response
    { //avec la méthode magique ^
        $seasons = $program->getSeasons();
        if (!$program)
            throw $this->createNotFoundException('Aucune série trouvée');
            
        $categories = $categoryRepository->findAll();

        return $this->render('program/show.html.twig', ['program' => $program, 'seasons' => $seasons,  'categories' => $categories,]);
    }

    #[Route('/program/{programId}/seasons/{seasonId}', requirements: ['seasonId' => '^[0-9]+$', 'programId' => '^[0-9]+$',], methods: ['GET'], name: 'season_show')]
    public function showSeason(
        int $programId,
        int $seasonId,
        ProgramRepository $programRepository,
        SeasonRepository $seasonRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $program = $programRepository->findOneBy(['id' => $programId]);
        if (!$program)
            throw $this->createNotFoundException('Aucune série trouvée');

        $season = $seasonRepository->findOneBy(['id' => $seasonId]);

        if (!$season)
            throw $this->createNotFoundException('Aucune season trouvée');

        $categories = $categoryRepository->findAll();

        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season,  'categories' => $categories,]);
    }
}
