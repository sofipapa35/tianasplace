<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Date;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index(Request $request, CommentRepository $commentRepository, EntityManagerInterface $entityManager): Response
    {
        // Nouveau commentaire
        $comment = new Comment();
        
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide on stocke ses données à la bdd
            $comment->setUser($this->getUser());
            $entityManager->persist($comment);
            $entityManager->flush();
            return new RedirectResponse($this->generateUrl('comment'));


        }
        // On récupère tous les commentaires du plus récent au plus ancien
        $comment=$commentRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('comment/index.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }
}
