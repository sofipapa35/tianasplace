<?php

namespace App\Controller;

use DateTime;
use App\Entity\Reservation;
use App\Entity\Disponibility;
use App\Form\DisponibilityType;
use App\Repository\JourRepository;
use App\Repository\HeureRepository;
use App\Repository\PersonnesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DisponibilityRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DisponibilityController extends AbstractController
{
    /**
     * @Route("/disponibility", name="disponibility")
     */
    public function index(Request $request, EntityManagerInterface $entityManagerInterface, HeureRepository $heureRepository, PersonnesRepository $personnesRepository, JourRepository $jourRepository, DisponibilityRepository $disponibilityRepository, MailerInterface $mailer): Response
    {
        $user = $this -> getUser();
        
        $dispo = new Disponibility();
        $reservation = new Reservation();
        $form = $this->createForm(DisponibilityType::class, $dispo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setJour(new DateTime($request->request->get("disponibility")['jour'])); // On sauvegarde la date dans le tableau de Reservation
            $dateId = $jourRepository->findOneBy(['jour' => new DateTime($request->request->get("disponibility")['jour'])]);
            $dateId = $dateId->getId(); // id de la date
            
            $timeId = $request->request->get("disponibility")['heure']; // On recupere l'id de l'heure
            $time = $heureRepository->findOneBy(['id' => $timeId]); // On cherche l'heure qui correspond à l'id
            $reservation->setHeure($time->getHeure()); // On sauvegarde l'heure dans le tableau de Reservation

            $peopleId = $request->request->get("disponibility")['personnes']; // On recupere l'id du nombre de personnes
            $people = $personnesRepository->findOneBy(['id' => $peopleId]); // On cherche le nombre de personnes qui correspond à l'id
            
            $reservation->setPersonnes($people->getPersonnes()); // On sauvegarde le nombre de personnes dans le tableau de Reservation
                        
            $people = $people->getPersonnes();
            if ($people % 2 != 0) {
                // Si le nombre de personnes est impair on ajoute 1
                $people += 1;
                $peopleId = $personnesRepository->findBy(['personnes' => $people]);
                $peopleId = $peopleId[0]->getId();
            }
            
            $disponibility  = $disponibilityRepository->findOneBy([
                "jour" => $dateId,
                "heure" => $timeId,
                "personnes" => $peopleId
            ]);
            $disponibility->setCount($disponibility->getCount() - 1); // On réduit le nombre de disponibility qui correspond par 1
            
            $reservation->setName($request->request->get("disponibility")['name']);
            $reservation->setEmail($request->request->get("disponibility")['email']);
            
            if($user){
                $reservation->setUser($user);
            }
            
            $entityManagerInterface->persist($reservation);
            $entityManagerInterface->persist($disponibility);
            $entityManagerInterface->flush();

            $email = (new TemplatedEmail())
                ->from('reservation@tianasplace.com')
                ->to($reservation->getEmail())
                ->subject('La reservation est confirmée')
                ->htmlTemplate('disponibility/email_de_confirmation.html.twig')
                ->context(compact('reservation', 'user'));

            $mailer->send($email);
            $this->addFlash('success', 'La réservation a été effectuée avec succès');
            return new RedirectResponse($this->generateUrl('disponibility'));
        }

        return $this->render('disponibility/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/getPeople", methods={"POST"})
     */
    public function getPeople(Request $request, DisponibilityRepository $disponibilityRepository, JourRepository $jourRepository, PersonnesRepository $personnesRepository): Response
    {
        $jour = $request->request->get('jour'); // On recupere le jour
        // On trouve le jour dans la table Jour de la base de données et on recupere son id
        $jourId = $jourRepository->findBy(['jour' => new DateTime($jour)]);
        $jourId = $jourId[0]->getId();

        // On fait appel à une requete pour trouver toutes les disponibilités où la date est la date saisie et le count est supérieur à 0
        $people = $disponibilityRepository->getDatePeople($jourId);

        // On prepare les options pour le champ du nombre de personnes
        $options = "<option selected>Choisir</option>";
        foreach ($people as $p) {
            // On fabrique les données pour les nombres des personnes impairs
            $ppOdd = $p->getPersonnes()->getPersonnes() - 1;
            $pIdOdd = $personnesRepository->findby(['personnes' => $ppOdd]);
            $pIdOdd = $pIdOdd[0]->getId();

            // On ajoute les options impairs et pairs pour chaque boucle 
            $options .= '<option value="' . $pIdOdd . '">' . $ppOdd . '</option>';
            $options .= '<option value="' . $p->getPersonnes()->getId() . '">' . $p->getPersonnes()->getPersonnes() . '</option>';
        }
        return new Response($options);
    }

    /**
     * @Route("/getTime", methods={"POST"})
     */
    public function getTime(Request $request, DisponibilityRepository $disponibilityRepository, JourRepository $jourRepository, PersonnesRepository $personnesRepository): Response
    {
        // dd($request->request);
        $jour = $request->request->get('jour'); // On recupere le jour
        $jourId = $jourRepository->findBy(['jour' => new DateTime($jour)]); // On cherche l'id du jour
        $jourId = $jourId[0]->getId(); // Id du jour

        $personneId = $request->request->get('nombre'); // On recupere l'id du nombre de personnes
        $personne = $personnesRepository->findBy(['id' => $personneId]);
        $personne = $personne[0]->getPersonnes();
        if ($personne % 2 != 0) {
            // Si le nombre de personnes est impair on ajoute 1
            $personne += 1;
            $personneId = $personnesRepository->findBy(['personnes' => $personne]);
            $personneId = $personneId[0]->getId();
        }
        // On fait appel à une requete pour trouver toutes les disponibilités où la date est la date saisie, 
        // le nombre de personnes est le nombre de personnes pair et le count est supérieur à 0
        $time = $disponibilityRepository->getDayPeopleTime($jourId, $personneId);

        // On fabrique les options
        $options = "<option selected>Choisir</option>";
        foreach ($time as $t) {
            $options .= '<option value="' . $t->getHeure()->getId() . '">' . $t->getHeure() . '</option>';
        }
        return new Response($options);
    }
}
