<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member")
     */
    public function index(Request $request, MemberRepository $memberRepository, EntityManagerInterface $entityManagerInterface, MailerInterface $mailer): Response
    {
        $member = new Member();
        
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide : 
                // On crée un token de securité
            $token = hash('sha256', uniqid());
            $member -> setValidationToken($token);
            $entityManagerInterface->persist($member);
            $entityManagerInterface->flush();
                // Un email de confirmation s'envoie au nouveau membre 
            $email = (new TemplatedEmail())
            ->from('newsletter@tianasplace.com')
            ->to($member->getEmail())
            ->subject('Inscription à la newsletter')
            ->htmlTemplate('member/inscription.html.twig')
            ->context(compact('member', 'token'));
            ;
            
            $mailer->send($email);
            
            $referer = $request->headers->get('referer');  
            $this -> addFlash('success', 'Inscription en attente de validation. Veuillez vérifier vos e-mails');
            return new RedirectResponse($referer);
        }elseif($form->isSubmitted() && !$form->isValid()){
            // Si le formulaire est soumis mais pas valide :
                // Un message flash nous informe que l'adresse mail existe déjà
            $referer = $request->headers->get('referer');  
            $this -> addFlash('danger', 'Deja enregisré');
            return new RedirectResponse($referer);
        }
        
        return $this->render('member/index.html.twig', [
            'form_member' => $form->createView(),
            $referer = $request->headers->get('referer')
        ]);
    }

    /**
     * @Route("/confirm/{id}/{token}", name="newsletters_confirm")
     */
    public function newsletters_confirm(Member $member, $token, EntityManagerInterface $entityManagerInterface): Response
    {
        if($member->getValidationToken()!= $token){ // On verifie si le token est le token du membre
            throw $this -> createNotFoundException('Page non trouvé'); // Si il n'est pas, il y aura une page not found (404)
        } 
        // Si on passe cette etape ça veut dire que le membre a le bon token
        $member -> setIsValid(true);
        
        $entityManagerInterface -> persist($member);
        $entityManagerInterface -> flush();
        $this -> addFlash('success', 'Inscription confirmée');
        return $this->redirectToRoute('home');
    }

     /**
     * @Route("/desincrire/{id}/{token}", name="newsletters_unsubscribe")
     */
    public function newsletters_unsubscribe(Member $member, EntityManagerInterface $entityManager, $token): Response
    {
        if($member->getValidationToken()!= $token){ // On verifie si le token est le token du membre
            throw $this -> createNotFoundException('Page non trouvé'); // Si il n'est pas, il y aura une page not found (404)
        } 
        $entityManager -> remove($member);
        $entityManager -> flush();
        $this -> addFlash('success', 'Newsletter supprimée');
        return $this->redirectToRoute('home');
    }
}
