<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\Photo1Type;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/photo")
 */
class AdminPhotoController extends AbstractController
{
    /**
     * @Route("/", name="admin_photo_index", methods={"GET"})
     */
    public function index(PhotoRepository $photoRepository): Response
    {
        return $this->render('admin_photo/index.html.twig', [
            'photos' => $photoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_photo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $photo = new Photo();
        $form = $this->createForm(Photo1Type::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('admin_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_photo_show", methods={"GET"})
     */
    public function show(Photo $photo): Response
    {
        return $this->render('admin_photo/show.html.twig', [
            'photo' => $photo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_photo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Photo1Type::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_photo/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_photo_delete", methods={"POST"})
     */
    public function delete(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($photo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_photo_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
