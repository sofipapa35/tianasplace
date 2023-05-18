<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\PasswordProfilType;
use App\Repository\OrderDetailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        // On récupère le user actif dans une variable $user, le user de l'application se récupère directement 
        // avec la méthode getUSer()
        $user = $this->getUser();
        
        $profile_form = $this->createForm(UserType::class, $user, ['email' => true]);  //On créer le première formulaire pour la modification des données du user  

        $profile_form->handleRequest($request);  // On hydrate (mettre des données dedans ) le formulaire avec les données POST se trouvant potentiellement dans la requête

        // Si il y a eu hydratation alors on verifie si le formulaire est soumis et valide
        // Alors on en traite les données et on flush (on met à jour la bdd)
        if ($profile_form->isSubmitted() && $profile_form->isValid()) {
            $entityManager->flush();
            $this->addFlash("success", "Vos informations ont bien été mises à jour.");
            // On redirige vers la même page
            $this->redirectToRoute('profile');
        }
        $pass_form = $this->createForm(PasswordProfilType::class, $user);  //On créer le deuxième formulaire pour la modification du mot de passe du user  
        $pass_form->handleRequest($request);
        
        // Si il y a eu hydratation alors on verifie si le formulaire est soumis et valide
        // Alors on en encode le mot de passe et on flush (on met à jour la bdd)
        if ($pass_form->isSubmitted() && $pass_form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $pass_form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash("success", "Votre mot de passe a bien été mises à jour.");
            // On redirige vers la même page
            $this->redirectToRoute('profile');
        }
        // Rendu
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'profile_form' => $profile_form->createView(),
            'pass_form' => $pass_form->createView(),
        ]);
    }
    /**
     * @Route("/commande/detail/{id}", name="myCommande_detail")
     */
    public function detail(int $id, OrderDetailRepository $orderDetailRepository): Response
    {
       $detail = $orderDetailRepository -> findBy(['commande' => $id]);
       return $this->render('user/mesCommandes.html.twig', [
        'detail' => $detail,
    ]);
    }
}
