<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Deliveries;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
