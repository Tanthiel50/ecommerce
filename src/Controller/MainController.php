<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/cart', name: 'display_cart')]
public function displayCart(EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser();
    if (!$user) {
        // Gérer l'utilisateur non connecté
    }

    $order = $entityManager->getRepository(Orders::class)->findOneBy(['id_userOrder' => $user, 'statut' => 'vide']);

    return $this->render('cart/display.html.twig', [
        'order' => $order,
    ]);
}
}
