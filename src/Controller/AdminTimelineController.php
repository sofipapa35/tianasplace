<?php

namespace App\Controller;

use App\Entity\Photo;
use DateTimeImmutable;
use App\Entity\Timeline;
use App\Form\TimelineType;
use App\Repository\PhotoRepository;
use App\Repository\MemberRepository;
use App\Repository\TimelineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/timeline")
 */
class AdminTimelineController extends AbstractController
{
    /**
     * @Route("/", name="admin_timeline_index", methods={"GET"})
     */
    public function index(TimelineRepository $timelineRepository): Response
    {
        return $this->render('admin_timeline/index.html.twig', [
            'timelines' => $timeline = $timelineRepository->findBy([], ['dateActu' => 'DESC','id' => 'DESC'])
        ]);
    }

    /**
     * @Route("/new", name="admin_timeline_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $timeline = new Timeline();
        $photo = new Photo();


        $form = $this->createForm(TimelineType::class, $timeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $timeline -> setUpdatedAt(new DateTimeImmutable());
            $photo -> setTimeline($timeline);
            $entityManager->persist($timeline);
            $entityManager->flush();

            return $this->redirectToRoute('admin_timeline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_timeline/new.html.twig', [
            'timeline' => $timeline,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_timeline_show", methods={"GET"})
     */
    public function show(Timeline $timeline): Response
    {
        return $this->render('admin_timeline/show.html.twig', [
            'timeline' => $timeline,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_timeline_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Timeline $timeline, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TimelineType::class, $timeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_timeline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_timeline/edit.html.twig', [
            'timeline' => $timeline,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_timeline_delete", methods={"POST"})
     */
    public function delete(Request $request, Timeline $timeline, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$timeline->getId(), $request->request->get('_token'))) {
            $entityManager->remove($timeline);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_timeline_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/envoyer/{id}", name="admin_send")
     */
    public function admin_send(Timeline $timeline, MemberRepository $memberRepository, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        // On trouve tous les membres de la newsletter
        $member = $memberRepository->findAll();
        foreach($member as $membre){
            if($membre->getIsValid()){           
                // Si le membre est validé on evoie le template de la newsletter 
                $email = (new TemplatedEmail())
                ->from('newsletter@tianasplace.com')
                ->to($membre->getEmail())
                ->subject($timeline->getTitle())
                ->htmlTemplate('timeline/newsletter.html.twig')
                ->context(compact('timeline', 'membre'))
            ;            
            $mailer->send($email);
            }
        }
        $timeline -> setIsSend(true);
        $entityManager->persist($timeline);
        $entityManager->flush();

        return $this->redirectToRoute('admin_timeline_index');
    }

    /**
     * @Route("/removephoto/{id}", name="remove-photo")
     */
    public function removePhoto(int $id, Request $request, PhotoRepository $photoRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $photo = $photoRepository->find($id);
        $timeline = $photo->getTimeline($id);
        $timeline->removePhoto($photo);
        $entityManagerInterface->persist($timeline);
        $entityManagerInterface->flush();
        $referer = $request->headers->get('referer');  
            $this -> addFlash('success', 'La photo a été supprimée');
            return new RedirectResponse($referer);
    }
}
