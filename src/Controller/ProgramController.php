<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/list.html.twig', [ 
            'programs' => $programs,
        ]);
    }


    #[Route('/{id}', requirements: ['id' => '^[0-9]+$'], methods: ['GET'], name: 'show')]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);

        if (!$program)
            throw $this->createNotFoundException('Aucune série trouvée');

        return $this->render('program/show.html.twig', ['program' => $program]);
    }
}
