<?php

namespace App\Controller;


use App\Classe\Panier;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/commande", name="commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/detail", name="_detail", methods={"GET", "POST"})
     */
    public function index(Panier $panier, Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
       //On prepare le formulaire pour l'ajout d'adresse en cas où le user n'a pas d'adresse
        $profile_form = $this->createForm(UserType::class, $user);  

        $profile_form->handleRequest($request);  
        if ($profile_form->isSubmitted() && $profile_form->isValid()) {
            $entityManager->flush();
            // On redirige vers la même page
            $referer = $request->headers->get('referer');
            $this->addFlash("success", "Vos informations ont bien été mises à jour.");
            return new RedirectResponse($referer);
        }
        $infos = [
            'address' => $user->getAddress(),
            'zip' => $user->getZip(),
            'ville' => $user->getVille()
        ];
        $count = count(array_filter($infos)) - count($infos);
        $commande = $panier->index();

        return $this->render('commande/index.html.twig', [
            'user' => $user,
            'commande' => $commande,
            'count' => $count,
            'infos' => $infos,
            'profile_form' => $profile_form->createView(),
        ]);
    }
}


