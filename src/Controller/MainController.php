<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductsRepository $productsRepository): Response
    {
        $productsRepository = $productsRepository->findAll();
        
        return $this->render('main/index.html.twig', [
            'products' => $productsRepository,
        ]);
    }
}
