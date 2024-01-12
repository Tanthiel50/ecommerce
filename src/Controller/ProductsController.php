<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Orders;
use App\Entity\Products;
use App\Form\ProductsType;
use App\Entity\OrderDetails;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
            $imagesToDelete = $request->get('images_to_delete', []);
            foreach ($imagesToDelete as $imageId) {
                $image = $entityManager->getRepository(Images::class)->find($imageId);
                if ($image) {
                    $entityManager->remove($image);
                    $imagePath = $this->getParameter('products_directory') . '/' . $image->getPath();
                    if (file_exists($imagePath)) {
                        unlink($imagePath); 
                    }
                }
            }
        
            $entityManager->flush();
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($request->isMethod('POST')) {
            $imageToDeleteId = $request->get('image_to_delete');
            if ($imageToDeleteId) {
                $imageToDelete = $entityManager->getRepository(Images::class)->find($imageToDeleteId);
                if ($imageToDelete && $imageToDelete->getProducts() === $product) {
                    $entityManager->remove($imageToDelete);
                    $entityManager->flush();
                }
                $imagePath = $this->getParameter('products_directory') . '/' . $imageToDelete->getPath();
                if (file_exists($imagePath)) {
                    unlink($imagePath); 
                }
            }
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

    #[Route('/display/{id}', name: 'app_products_display', methods: ['GET'])]
    public function display(Products $product): Response
    {
        // Assurez-vous d'ajouter la logique nécessaire pour récupérer les informations du produit
        // par exemple, récupérer des images ou d'autres détails liés au produit

        return $this->render('products/display.html.twig', [
            'product' => $product,
            // 'images' => $images, // Ajoutez d'autres variables si nécessaire
        ]);
    }

    #[Route('/add-to-cart/{id}', name: 'add_to_cart')]
public function addToCart(Request $request, Products $product, EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser(); // Récupérer l'utilisateur actuel
    if (!$user) {
        // Rediriger l'utilisateur non connecté ou gérer différemment
    }

    // Vérifier si une commande "vide" existe déjà pour cet utilisateur
    $order = $entityManager->getRepository(Orders::class)->findOneBy(['id_userOrder' => $user, 'statut' => 'vide']);

    if (!$order) {
        $order = new Orders();
        $order->setIdUserOrder($user);
        $order->setStatut('vide');
        $order->setDate(new \DateTime()); // Définir la date actuelle
        $entityManager->persist($order);
    }

    // Créer ou mettre à jour les détails de la commande
    $orderDetail = new OrderDetails();
    $orderDetail->setIdOrder($order);
    $orderDetail->addIdProduct($product);
    $orderDetail->setQuantity(1); // Exemple avec une quantité fixe
    $orderDetail->setPrice($product->getPrice());
    $entityManager->persist($orderDetail);

    $entityManager->flush();

    // Rediriger vers le panier ou la page produit
    return $this->redirectToRoute('display_cart');
}
}
