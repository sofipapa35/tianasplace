<?php

namespace App\Controller;

use App\Repository\CarouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     * @Route("/home", name="home")
     */
    public function index(CarouselRepository $carouselRepository): Response
    {
        $carousel = $carouselRepository -> findAll();
        return $this->render('home/index.html.twig', [
            'carousel' => $carousel,
        ]);
    }
}
