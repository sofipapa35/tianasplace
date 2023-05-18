<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use App\Repository\TimelineRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TimelineController extends AbstractController
{
    /**
     * @Route("/timeline", name="timeline")
     */
    public function index(TimelineRepository $timelineRepository, PhotoRepository $photoRepository): Response
    {

        return $this->render('timeline/index.html.twig', [
            'timeline' => $timelineRepository->findBy([], ['dateActu' => 'DESC']),
            'photo' => $photoRepository->findAll(),

        ]);
    }
}
