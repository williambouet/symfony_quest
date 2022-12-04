<?php

namespace App\Controller;


use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $program = new Program();
        // Create the form, linked with $category
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            $categories = $categoryRepository->findAll();
            return $this->redirectToRoute('program_index', ['categories' => $categories,]);
        }

        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
        ]);
    }




    #[Route('/list/{categoryId}', requirements: ['categoryId' => '^[0-9]+$'], methods: ['GET'], name: 'list')]
    public function list(int $categoryId, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $programs = $programRepository->findBy(['category' => $categoryId]);
        if (!$programs)
            throw $this->createNotFoundException('Aucune série trouvée');

        return $this->render('program/list.html.twig', [
            'programs' => $programs,
            'categories' => $categoryRepository->findAll(),
        ]);
    }




    #[Route('/{id}', requirements: ['id' => '^[0-9]+$'], methods: ['GET'], name: 'show')]
    public function show(Program $program,  CategoryRepository $categoryRepository): Response
    { //avec la méthode magique ^
        $seasons = $program->getSeasons();
        if (!$program)
            throw $this->createNotFoundException('Aucune série trouvée');

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            'categories' => $categoryRepository->findAll(),
        ]);
    }




    #[Route('/program/{programId}/seasons/{seasonId}', requirements: ['seasonId' => '^[0-9]+$', 'programId' => '^[0-9]+$',], methods: ['GET'], name: 'season_show')]
    public function showSeason(
        int $programId,
        int $seasonId,
        EpisodeRepository $episodeRepository,
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository,
    ): Response {

        $programs = $programRepository->findBy(['id' => $programId]);
        
        $episodes = $episodeRepository->findBy(['season' => $seasonId]);
        

        if (!$episodes)
            throw $this->createNotFoundException('Aucune season trouvée');

        return $this->render('program/season_show.html.twig', [
            'programs' => $programs,
            'episodes' => $episodes,
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
