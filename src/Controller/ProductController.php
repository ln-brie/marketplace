<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(ProductRepository $repo): Response
    {
        $produits = $repo->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $produits,
        ]);
    }

    #[Route('/product/{id}', name: 'single-product')]
    public function see_product(ProductRepository $repo, $id): Response
    {
        $produit = $repo->find($id);
        return $this->render('product/single.html.twig', [
            'product' => $produit,
        ]);
    }

    #[Route('/product/categorie/{cat}', name: 'produits-par-categorie')]
    public function get_products_by_category(ProductRepository $repo, $cat, CategoryRepository $catRepo)
    {

        $categorie = $catRepo->find($cat);
        $products = $repo->findByCategory($categorie);


        return $this->render('product/produits-par-categorie.html.twig', [
            'produits' => $products,
            'categorie' => $categorie
        ]);
    }

    #[Route('/add/product', name: 'ajout-produit')]
    public function add_product(EntityManagerInterface $manager, Request $request)
    {
        $product = new Product();
        $formProduct = $this->createForm(ProductType::class, $product)
            ->add('Ajouter', SubmitType::class);
        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()) {
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('product');
        }

        return $this->render('product/add-form.html.twig', [
            'product' => $product,
            'titre' => 'Ajouter',
            'formProduct' => $formProduct->createView()
        ]);
    }
    #[Route('/update/product/{id}', name: 'maj-produit')]
    public function maj_product(EntityManagerInterface $manager, Product $product, Request $request)
    {
        $formProduct = $this->createForm(ProductType::class, $product)
            ->add('Valider', SubmitType::class);
        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()) {
            //$manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('product');
        }

        return $this->render('product/add-form.html.twig', [
            'product' => $product,
            'titre' => 'Modifier',
            'formProduct' => $formProduct->createView()
        ]);
    }

}
