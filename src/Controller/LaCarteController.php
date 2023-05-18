<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LaCarteController extends AbstractController
{
    /**
     * @Route("/la-carte/{title}", name="la_carte_categorie")
     */
    public function index(CategoryRepository $categoryRepository, string $title): Response
    {
        // On récupère les produits par la categorie choisie
        $product_category = $categoryRepository->findByTitle($title);
        // On récupère tous les produits
        $categories = $categoryRepository->findAll();
        // 
        return $this->render('la_carte/index.html.twig', [
            'product_category' => $product_category,
            'categories' => $categories
        ]);
    }
    /**
     * @Route("/la-carte/detail/{id}", name="la_carte_detail")
     */
    public function detail(ProductRepository $productRepository, string $id): Response
    {
        // On récupère les produits par la categorie choisie
        $product_detail = $productRepository->findById($id);

        return $this->render('la_carte/productDetails.html.twig', [
            'product_detail' => $product_detail,
        ]);
    }
}
