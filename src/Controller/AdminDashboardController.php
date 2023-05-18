<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $user = $this->getUser();
        $topVente = $productRepository->findBy([], ['sold' => 'DESC'], 5);
        return $this->render('admin_dashboard/index.html.twig', [
            'user' => $user,
            'topVente' => $topVente,
        ]);
    }
}
