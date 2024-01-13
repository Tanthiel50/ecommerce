<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Orders;
use App\Entity\Deliveries;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductsRepository $productsRepository, CategoriesRepository $categoriesRepository): Response
    {
        $categoriesRepository = $categoriesRepository->findAll();
        $latestProducts = $productsRepository->findLatestProducts(4); 
        $productsOnSale = $productsRepository->findProductsOnSale(); 
        return $this->render('main/index.html.twig', [
            'products' => $latestProducts,
            'categories' => $categoriesRepository,
            'productsOnSale' => $productsOnSale,
        ]);
    }
}
