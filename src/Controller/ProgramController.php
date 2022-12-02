<?php

namespace App\Controller;


use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\SeasonRepository;
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

        $categories = $categoryRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $program = new Program();
        // Create the form, linked with $category
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $programRepository->save($program, true);

            $categories = $categoryRepository->findAll();
            return $this->redirectToRoute('program_index', ['categories' => $categories,]);
        }

        $categories = $categoryRepository->findAll();
        // Render the form (best practice)
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
            'categories' => $categories,
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
