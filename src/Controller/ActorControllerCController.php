<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actor/controller/c')]
class ActorControllerCController extends AbstractController
{
    #[Route('/', name: 'app_actor_controller_c_index', methods: ['GET'])]
    public function index(ActorRepository $actorRepository): Response
    {
        return $this->render('actor_controller_c/index.html.twig', [
            'actors' => $actorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_actor_controller_c_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActorRepository $actorRepository): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actorRepository->save($actor, true);

            return $this->redirectToRoute('app_actor_controller_c_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actor_controller_c/new.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actor_controller_c_show', methods: ['GET'])]
    public function show(Actor $actor): Response
    {
        return $this->render('actor_controller_c/show.html.twig', [
            'actor' => $actor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_actor_controller_c_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actor $actor, ActorRepository $actorRepository): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actorRepository->save($actor, true);

            return $this->redirectToRoute('app_actor_controller_c_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actor_controller_c/edit.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actor_controller_c_delete', methods: ['POST'])]
    public function delete(Request $request, Actor $actor, ActorRepository $actorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actor->getId(), $request->request->get('_token'))) {
            $actorRepository->remove($actor, true);
        }

        return $this->redirectToRoute('app_actor_controller_c_index', [], Response::HTTP_SEE_OTHER);
    }
}
