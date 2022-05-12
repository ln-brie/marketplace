<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'category')]
    public function index(CategoryRepository $repo): Response
    {
        $cats = $repo->findAll();
        return $this->render('category/index.html.twig', [
            'cats' => $cats,
        ]);
    }

    #[Route('/add/category', name: 'ajout-categorie')]
    public function add_category(EntityManagerInterface $manager, Request $request)
    {
        $category = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category)
            ->add('Ajouter', SubmitType::class);
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('category');
        }

        return $this->render('category/add-form.html.twig', [
            'titre' => 'Ajouter une catégorie',
            'category' => $category,
            'formCategory' => $formCategory->createView()
        ]);
    }

    #[Route('/update/category/{id}', name: 'maj-categorie')]
    public function update_category(EntityManagerInterface $manager, Request $request, Category $cat)
    {
        $formCategory = $this->createForm(CategoryType::class, $cat)
            ->add('Valider', SubmitType::class);
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('category');
        }

        return $this->render('category/add-form.html.twig', [
            'titre' => 'Mettre à jour une catégorie',
            'formCategory' => $formCategory->createView()
        ]);
    }

    
}
