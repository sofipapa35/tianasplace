<?php

namespace App\Controller;

use Stripe\Util\Set;
use DateTimeImmutable;
use App\Entity\Disponibility;
use App\Form\Disponibility1Type;
use App\Repository\JourRepository;
use App\Repository\HeureRepository;
use App\Repository\PersonnesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DisponibilityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/disponibility")
 */
class AdminDisponibilityController extends AbstractController
{
    /**
     * @Route("/", name="admin_disponibility_index", methods={"GET"})
     */
    public function index(DisponibilityRepository $disponibilityRepository, JourRepository $jourRepository, EntityManagerInterface $entityManager, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $data = $disponibilityRepository->findAll();

        $disponibility = $paginatorInterface -> paginate(
            $data,
            $request -> query -> getInt('page', 1),
            20
        );

        
        $pastdDates = $jourRepository->findPastDates();
        // dd($pastdDates);

        // foreach($pastdDates as $date){

        //     $entityManager->remove($date);
        // }
        // $entityManager->flush();
        return $this->render('admin_disponibility/index.html.twig', [
            'disponibility' => $disponibility,
        ]);
    }

    /**
     * @Route("/new", name="admin_disponibility_new", methods={"GET", "POST"})
     */
    public function new(HeureRepository $heureRepository, JourRepository $jourRepository, DisponibilityRepository $disponibilityRepository, PersonnesRepository $personnesRepository, EntityManagerInterface $entityManager): Response
    {
        // On trouve la derniere date du Disponibility
        $lastDate = $disponibilityRepository->findBy([], ['jour' => 'DESC'], 1, 0); 
        
        
        if($lastDate){
            // Si elle existe on trouve le jour
            $lastDate = $lastDate[0]->getJour()->getJour();
            // et les jours suivants
            $jour = $jourRepository->getNewDates($lastDate);
        }else{
            // Sinon on trouve toutes les jour du Jour
            $jour = $jourRepository->findAll();
        }
        
        // on recupere toutes les heures et les personnes
        $heure = $heureRepository->findAll();
        $personnes = $personnesRepository->findAll();
        foreach ($jour as $j) {
            foreach ($heure as $h) {
                foreach ($personnes as $p) {
                    // Pour chaque jour, heure et personne
                    if ($p->getPersonnes() % 2 == 0) {
                            // Si le nombre de personnes est pair
                            // il y a une nouvelle Disponibility
                            $disponibility = new Disponibility();
                            // on set le jour, l'heure, le nombre de personnes et le count
                        $disponibility->setJour($j);
                        $disponibility->setHeure($h);
                        $disponibility->setPersonnes($p);
                        $disponibility->setCount($p->getCount());
                        $entityManager->persist($disponibility);
                    }
                }
            }
        }
        $entityManager->flush();
        $disponibility = $disponibilityRepository->findAll();
        return $this->renderForm('admin_disponibility/index.html.twig', [
            'disponibility' => $disponibility,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_disponibility_show", methods={"GET"})
     */
    public function show(Disponibility $disponibility): Response
    {
        return $this->render('admin_disponibility/show.html.twig', [
            'disponibility' => $disponibility,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_disponibility_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Disponibility $disponibility, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Disponibility1Type::class, $disponibility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_disponibility_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_disponibility/edit.html.twig', [
            'disponibility' => $disponibility,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_disponibility_delete", methods={"POST"})
     */
    public function delete(Request $request, Disponibility $disponibility, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $disponibility->getId(), $request->request->get('_token'))) {
            $entityManager->remove($disponibility);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_disponibility_index', [], Response::HTTP_SEE_OTHER);
    }
}
