<?php

namespace App\Controller;


use App\Classe\Panier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/panier")
 */

class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index")
     */
    public function index(Panier $panier): Response
    {
    //dd($panier -> index());
        return $this->render('panier/index.html.twig', [
            'panier' => $panier -> index()
        ]);
    }
    /**
     * @Route("/ajouter/{id}", name="panier_add")
     */
    public function add(Panier $panier,Request $request, $id): Response
    {
        // dd($panier -> add($id));
        // On appelle la fonction add
        $panier->add($id);
        $referer = $request->headers->get('referer');
        $this->addFlash('success', 'Le produit a été ajouté avec success');
        return new RedirectResponse($referer);
    }
    /**
     * @Route("/supprimer/{id}", name="panier_remove")
     */
    public function decrease(Panier $panier,Request $request, $id): Response
    {
        $panier->decrease($id);
        
        $referer = $request->headers->get('referer');
        $this->addFlash('success', 'Le produit a été supprimé');
        return new RedirectResponse($referer);
    }
     /**
     * @Route("/delete", name="panier_remove_all")
     */
    public function remove_all(Panier $panier,Request $request, $id): Response
    {
        $panier -> delete($id);

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
    public function getArticles(Panier $panier){
        $total = 0;
        if ($panier->get() != null) {
            foreach($panier->get() as $prod){
                // dd($prod);
                $total += $prod;
            }
        };
        return new Response($total);
    }
}
