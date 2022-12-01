<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('category_index');
        }

        $categories = $categoryRepository->findAll();
        
        // Render the form (best practice)
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
            'categories' => $categories,
        ]);
    }
    
    #[Route('/{categoryName}', requirements: ['categoryName' => '^[a-zA-Z\-_]+$'], methods: ['GET'], name: 'show')]
    public function show(string $categoryName, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
        $programs = $programRepository->findBy(['category' => $category], ['title' => 'ASC'], 5);

        if (!$programs)
            throw $this->createNotFoundException('Aucun programme pour la catégorie.');
        
        $categories = $categoryRepository->findAll();

        return $this->render('category/show.html.twig', [
            'programs' => $programs, 
            'category' => $category, 
            'categories' => $categories,
        ]);
    }
}
