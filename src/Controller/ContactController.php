<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);
        // Pour traiter les données du formulaire, on appelle la méthode handleRequest()
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est est soumis est valide
            // on recupere ses données
            $contactFormData = $form->getData();
            // On crée un nouveau email
            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('tiana@gmail.com')
                ->subject($contactFormData['subject'])
                ->text('De '. $contactFormData['fullName'] . ' :' . $contactFormData['message']);
            $mailer->send($message);

            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}