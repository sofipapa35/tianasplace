<?php

namespace App\Controller;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Entity\Jour;
use App\Form\JourType;
use App\Repository\JourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/jour")
 */
class AdminJourController extends AbstractController
{
    /**
     * @Route("/", name="admin_jour_index", methods={"GET"})
     */
    public function index(JourRepository $jourRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    { 
        $data = $jourRepository->findAll();
        // Pagination pour afficher les jours
        $jours = $paginatorInterface -> paginate(
            $data,
            $request -> query -> getInt('page', 1),
            20
        );
        return $this->render('admin_jour/index.html.twig', [
            'jours' => $jours,
        ]);
    }

    /**
     * @Route("/new", name="admin_jour_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jour = new Jour();
        $form = $this->createForm(JourType::class, $jour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On recupere la date du debut et la date de la fin
            $startDate = $request->request->all()['jour']['dateStart'];
            $endDate = $request->request->all()['jour']['dateEnd'];
            
            // la periode contienne toutes les dates entre ces deux dates
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod(new DateTime($startDate), $interval, new DateTime($endDate));
            
            foreach ($period as $d) {
                // Pour chaque date on crée le jour
                $jour = new Jour();
                $jour->setJour($d);
                $entityManager->persist($jour);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_jour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_jour/new.html.twig', [
            'jour' => $jour,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_jour_show", methods={"GET"})
     */
    public function show(Jour $jour): Response
    {
        return $this->render('admin_jour/show.html.twig', [
            'jour' => $jour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_jour_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Jour $jour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JourType::class, $jour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_jour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_jour/edit.html.twig', [
            'jour' => $jour,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_jour_delete", methods={"POST"})
     */
    public function delete(Request $request, Jour $jour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($jour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_jour_index', [], Response::HTTP_SEE_OTHER);
    }
}
