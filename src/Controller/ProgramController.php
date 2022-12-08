<?php

namespace App\Controller;


use App\Entity\Program;
use App\Form\ProgramType;
use App\Service\ProgramDuration;
use Symfony\Component\Mime\Email;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }


    #[Route('/app', name: 'app_program_index', methods: ['GET'])]
    public function app_index(ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('program/app_index.html.twig', [
            'programs' => $programRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }


    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {

        return $this->render('program/index.html.twig', [
            'programs' => $programRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_program_new')]
    public function new(Request $request, MailerInterface $mailer, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $this->slugger->slug($program->getTitle());
            $program->setSlug($slug);   
            $programRepository->save($program, true);
            $this->addFlash('success', 'Le programme est ajouté.');

            $mail = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('william.bouet.14@gmail.com')
                ->subject('Une nouvelle série dans la base')
                ->html($this->renderView('program/newProgramEmail.html.twig', ['program' => $program]));
            $mailer->send($mail);



            return $this->redirectToRoute('program_app_program_index', ['categories' => $categoryRepository->findAll(),]);
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

    #[Route('/{slug}', name: 'app_program_show', methods: ['GET'])]
    public function app_show(Program $program, CategoryRepository $categoryRepository,): Response
    {
        return $this->render('program/app_show.html.twig', [
            'program' => $program,
            'categories' => $categoryRepository->findAll(),
        ]);
    }


    #[Route('/show/{slug}', requirements: ['slug' => '^[a-zA-Z0-9\-]+$'], methods: ['GET'], name: 'show')]
    public function show(Program $program,  CategoryRepository $categoryRepository, ProgramDuration $programDuration): Response
    { //avec la méthode magique ^
        if (!$program)
            throw $this->createNotFoundException('Aucune série trouvée');

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $program->getSeasons(),
            'categories' => $categoryRepository->findAll(),
            'duration' => $programDuration->calculate($program),
        ]);
    }





    #[Route('/program/{slug}/seasons/{seasonId}', requirements: ['seasonId' => '^[0-9]+$','slug' => '^[a-zA-Z0-9\-]+$',], methods: ['GET'], name: 'season_show')]
    public function showSeason(
        string $slug,
        int $seasonId,
        EpisodeRepository $episodeRepository,
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository,
    ): Response {

        $programs = $programRepository->findBy(['slug' => $slug]);
        $episodes = $episodeRepository->findBy(['season' => $seasonId]);

        if (!$episodes)
            throw $this->createNotFoundException('Aucune season trouvée');

        return $this->render('program/season_show.html.twig', [
            'programs' => $programs,
            'episodes' => $episodes,
            'categories' => $categoryRepository->findAll(),
        ]);
    }


    #[Route('/delete/{id}', name: 'app_program_delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
            $this->addFlash('danger', 'Le programme est supprimé.');
        }

        return $this->redirectToRoute('program_app_program_index', [], Response::HTTP_SEE_OTHER); 
   }

    #[Route('/edit/{slug}', name: 'app_program_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository, CategoryRepository $categoryRepository,): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $this->slugger->slug($program->getTitle());
            $program->setSlug($slug); 
            $programRepository->save($program, true);
            $this->addFlash('success', 'Le programme est modifié.');

            return $this->redirectToRoute('program_app_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
        ]);
    }




}
