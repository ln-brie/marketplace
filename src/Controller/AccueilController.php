<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(ProductRepository $repo): Response
    {
        $products = $repo->findTheThreeLastOnes();
        
        return $this->render('accueil/index.html.twig', [
            'products' => $products
        ]);
    }
}
