<?php

namespace App\Controller;

use App\Entity\Sales;
use App\Form\SalesType;
use App\Entity\Products;
use App\Repository\SalesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/sales')]
class SalesController extends AbstractController
{
    #[Route('/', name: 'app_sales_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(SalesRepository $salesRepository): Response
    {
        return $this->render('sales/index.html.twig', [
            'sales' => $salesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sales_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sale = new Sales();
        $form = $this->createForm(SalesType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedProducts = $form->get('id_product')->getData();
            foreach ($selectedProducts as $product) {
                $product->setSales($sale);
                $entityManager->persist($product);
            }

            $entityManager->persist($sale);
            $entityManager->flush();

            return $this->redirectToRoute('app_sales_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sales/new.html.twig', [
            'sale' => $sale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sales_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Sales $sale): Response
    {
        return $this->render('sales/show.html.twig', [
            'sale' => $sale,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_sales_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Sales $sale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalesType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $selectedProducts = $form->get('id_product')->getData();

            // Parcourir tous les produits disponibles
            $allProducts = $entityManager->getRepository(Products::class)->findAll();
            foreach ($allProducts as $product) {
                if ($selectedProducts->contains($product)) {
                    // Si le produit est sélectionné, l'associer à la vente
                    $product->setSales($sale);
                } else {
                    // Si le produit n'est pas sélectionné, dissocier de la vente
                    $product->setSales(null);
                }
                $entityManager->persist($product);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_sales_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sales/edit.html.twig', [
            'sale' => $sale,
            'form' => $form,
        ]);
    }





    #[Route('/{id}', name: 'app_sales_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Sales $sale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sale->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sales_index', [], Response::HTTP_SEE_OTHER);
    }
}
