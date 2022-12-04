<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {

        return $this->render('category/index.html.twig', ['categories' => $categoryRepository->findAll()]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('category_index');
        }

        
        // Render the form (best practice)
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    
    #[Route('/{categoryName}', requirements: ['categoryName' => '^[a-zA-Z\-_]+$'], methods: ['GET'], name: 'show')]
    public function show(string $categoryName, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
        $programs = $programRepository->findBy(['category' => $category], ['title' => 'ASC']);

        if (!$programs)
            throw $this->createNotFoundException('Aucun programme pour la catégorie.');
        

        return $this->render('category/show.html.twig', [
            'programs' => $programs, 
            'category' => $category, 
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
