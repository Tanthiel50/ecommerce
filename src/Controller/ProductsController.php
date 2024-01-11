<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/products')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'app_products_index', methods: ['GET'])]
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_products_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);
        // dd($product -> getImage() -> getAlt());

        if ($form->isSubmitted() && $form->isValid()) {
            $productFiles = $form->get('image')->getData();
            foreach ($productFiles as $productFile) {
                if ($productFile instanceof UploadedFile) {
                    $originalFilename = pathinfo($productFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $productFile->guessExtension();

                    try {
                        $productFile->move(
                            $this->getParameter('products_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'avatar. Veuillez réessayer.');
                    }

                    $image = new Images();
                    // $image->setProducts($product);
                    $image->setPath($newFilename);

                    $product->addImage($image);
                }
            }

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_products_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        $categories = $product->getCategories();
        $images = $product->getImage();
        $image = $images->first() ?: null;

        return $this->render('products/show.html.twig', [
            'product' => $product,
            'image' => $image,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Products $product, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement des images, similaire à la méthode 'new'
            $productFiles = $form->get('image')->getData();
            foreach ($productFiles as $productFile) {
                if ($productFile instanceof UploadedFile) {
                    $originalFilename = pathinfo($productFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $productFile->guessExtension();

                    try {
                        $productFile->move(
                            $this->getParameter('products_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'avatar. Veuillez réessayer.');
                    }

                    $image = new Images();
                    // $image->setProducts($product);
                    $image->setPath($newFilename);

                    $product->addImage($image);
                }
            }
        
            $entityManager->flush();
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('products/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_products_delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            // Supprimez chaque image liée au produit
            foreach ($product->getImage() as $image) {
                $imagePath = $this->getParameter('products_directory') . '/' . $image->getPath();
                if (file_exists($imagePath)) {
                    unlink($imagePath); 
                }
            }
    
            // Supprimez le produit
            $entityManager->remove($product);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    }
}
